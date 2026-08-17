<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Api\ApiController;
use App\Models\Country;
use App\Models\SupplyChain;
use App\Models\SupplyChainRole;
use App\Models\SuppplyChainStatus;
use App\Models\User;
use Illuminate\Http\Request;

class SessionController extends ApiController
{
    public function bootstrap(Request $request)
    {
        $user = $this->requireUser($request);
        $role = $this->role($user);

        return $this->ok('Session loaded successfully', [
            'profile'       => $this->profilePayload($user),
            'role'          => $role,
            'role_label'    => $this->roleLabel($user),
            'capabilities'  => $this->capabilities($user),
            'tabs'          => $this->tabs($user),
            'quick_actions' => $this->quickActions($user),
            'scanner'       => $this->scannerConfig($user),
            'theme'         => [
                'accent'        => '#0F62FE',
                'greeting'      => $this->greeting(),
                'display_name'  => $this->displayName($user),
            ],
        ]);
    }

    public function me(Request $request)
    {
        $user = $this->requireUser($request);

        return $this->ok('Profile fetched successfully', [
            'profile' => $this->profilePayload($user),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $this->requireUser($request);

        $this->validateInput($request, [
            'name'         => 'nullable|string|max:100',
            'first_name'   => 'nullable|string|max:50',
            'middle_name'  => 'nullable|string|max:50',
            'last_name'    => 'nullable|string|max:50',
            'email'        => 'nullable|email|max:100',
            'dob'          => 'nullable|string|max:20',
            'gender'       => 'nullable|in:m,f,o,u',
            'address_one'  => 'nullable|string|max:255',
            'address_two'  => 'nullable|string|max:255',
            'zip'          => 'nullable|string|max:20',
            'city_id'      => 'nullable|integer',
        ]);

        if ($request->filled('email')) {
            $taken = User::where('email', $request->input('email'))
                ->where('id', '!=', $user->id)
                ->exists();

            if ($taken) {
                return $this->fail('This email is already registered.', ['email' => ['Email already in use']], 422);
            }
        }

        $fields = [
            'name', 'first_name', 'middle_name', 'last_name', 'email',
            'dob', 'gender', 'address_one', 'address_two', 'zip', 'city_id',
        ];

        foreach ($fields as $field) {
            if ($request->exists($field)) {
                $user->{$field} = $request->input($field);
            }
        }

        $user->save();

        return $this->ok('Profile updated successfully', [
            'profile' => $this->profilePayload($user->fresh()),
        ]);
    }

    public function logout(Request $request)
    {
        $user = $this->requireUser($request);

        $user->otp = null;
        $user->save();

        return $this->ok('Logged out successfully');
    }

    public function deleteAccount(Request $request)
    {
        $user = $this->requireUser($request);

        $this->requireRole($user, [self::ROLE_CONSUMER]);

        $user->status = '2';
        $user->active = '0';
        $user->save();
        $user->delete();

        return $this->ok('Your account has been deleted.');
    }

    public function masters(Request $request)
    {
        $countries = Country::select('id', 'iso', 'name', 'nicename', 'phonecode', 'currency')
            ->orderBy('nicename', 'asc')
            ->get()
            ->toArray();

        $statuses = [];

        foreach (SuppplyChainStatus::get() as $status) {
            $statuses[] = [
                'label'   => $status->status,
                'value'   => $status->status,
                'comment' => $status->placeholder,
            ];
        }

        return $this->ok('Masters fetched successfully', [
            'countries'            => $countries,
            'supply_chain_status'  => $statuses,
            'report_issue_types'   => [
                ['label' => 'Fake / counterfeit product', 'value' => 'counterfeit'],
                ['label' => 'Damaged packaging',         'value' => 'damaged'],
                ['label' => 'Expired product',           'value' => 'expired'],
                ['label' => 'Wrong product inside',      'value' => 'wrong_product'],
                ['label' => 'Other',                     'value' => 'other'],
            ],
        ]);
    }

    protected function profilePayload($user)
    {
        $company = $user->getCompany;

        $payload = [
            'id'           => $user->id,
            'name'         => $this->displayName($user),
            'first_name'   => $user->first_name,
            'middle_name'  => $user->middle_name,
            'last_name'    => $user->last_name,
            'phone_code'   => $user->phone_code,
            'phone'        => $user->phone,
            'email'        => $user->email,
            'dob'          => $user->dob,
            'gender'       => $user->gender,
            'photo'        => $user->photo,
            'address_one'  => $user->address_one,
            'address_two'  => $user->address_two,
            'zip'          => $user->zip,
            'type'         => (string) $user->type,
            'role'         => $this->role($user),
            'role_label'   => $this->roleLabel($user),
            'designation'  => $user->who_you_are,
            'brand'        => $user->brand,
            'member_since' => $this->date($user->created_at, 'M Y'),
        ];

        if ($company) {
            $payload['company'] = [
                'name'    => $company->name,
                'gst'     => $company->gst,
                'cin'     => $company->cin,
                'address' => companyAddress($company),
            ];
        }

        if ($this->role($user) === self::ROLE_SUPPLY_CHAIN) {
            $node = SupplyChain::where('user_id', $user->id)->first();
            $scRole = SupplyChainRole::where('user_id', $user->id)->first();

            $payload['supply_chain'] = [
                'node_role'  => $scRole ? $scRole->name : ($user->who_you_are ?: 'Supply Chain User'),
                'has_parent' => $node && $node->supply_chain_parent_id ? true : false,
                'parent'     => $node && $node->supply_chain_parent_id && $node->getUser
                    ? optional(User::find($node->supply_chain_parent_id))->name
                    : null,
            ];
        }

        return $payload;
    }

    protected function capabilities($user)
    {
        $role = $this->role($user);

        $base = [
            'scan_product'        => false,
            'scan_supply_chain'   => false,
            'report_product'      => false,
            'rewards'             => false,
            'wallet'              => false,
            'cases'               => false,
            'brand_dashboard'     => false,
            'supply_chain_board'  => false,
            'alerts'              => false,
            'scan_history'        => true,
        ];

        switch ($role) {
            case self::ROLE_CONSUMER:
                $base['scan_product']   = true;
                $base['report_product'] = true;
                $base['rewards']        = true;
                $base['wallet']         = true;
                break;

            case self::ROLE_SUPPLY_CHAIN:
                $base['scan_supply_chain']  = true;
                $base['supply_chain_board'] = true;
                $base['alerts']             = true;
                break;

            case self::ROLE_INSPECTOR:
            case self::ROLE_AUTHORITY:
                $base['scan_product']   = true;
                $base['cases']          = true;
                $base['alerts']         = true;
                $base['report_product'] = true;
                break;

            case self::ROLE_BRAND:
            case self::ROLE_ADMIN:
                $base['scan_product']       = true;
                $base['brand_dashboard']    = true;
                $base['alerts']             = true;
                $base['cases']              = true;
                $base['supply_chain_board'] = true;
                break;
        }

        return $base;
    }

    protected function tabs($user)
    {
        $role = $this->role($user);

        $definitions = [
            self::ROLE_CONSUMER => [
                ['key' => 'home',     'label' => 'Home',    'icon' => 'home',       'endpoint' => 'consumer/home'],
                ['key' => 'scan',     'label' => 'Scan',    'icon' => 'qr_scanner', 'endpoint' => 'p/{code}'],
                ['key' => 'rewards',  'label' => 'Rewards', 'icon' => 'gift',       'endpoint' => 'rewards/summary'],
                ['key' => 'history',  'label' => 'My scans', 'icon' => 'history',   'endpoint' => 'consumer/scans'],
                ['key' => 'profile',  'label' => 'Profile', 'icon' => 'user',       'endpoint' => 'app/me'],
            ],
            self::ROLE_SUPPLY_CHAIN => [
                ['key' => 'home',        'label' => 'Home',       'icon' => 'dashboard',  'endpoint' => 'supply-chain/dashboard'],
                ['key' => 'scan',        'label' => 'Scan',       'icon' => 'qr_scanner', 'endpoint' => 'supply-chain/scan'],
                ['key' => 'consignments','label' => 'Shipments', 'icon' => 'package',    'endpoint' => 'supply-chain/consignments'],
                ['key' => 'alerts',      'label' => 'Alerts',     'icon' => 'bell',       'endpoint' => 'supply-chain/alerts'],
                ['key' => 'profile',     'label' => 'Profile',    'icon' => 'user',       'endpoint' => 'app/me'],
            ],
            self::ROLE_INSPECTOR => [
                ['key' => 'home',    'label' => 'Home',    'icon' => 'dashboard',  'endpoint' => 'inspector/dashboard'],
                ['key' => 'cases',   'label' => 'Cases',   'icon' => 'folder',     'endpoint' => 'inspector/cases'],
                ['key' => 'scan',    'label' => 'Verify',  'icon' => 'qr_scanner', 'endpoint' => 'p/{code}'],
                ['key' => 'profile', 'label' => 'Profile', 'icon' => 'user',       'endpoint' => 'app/me'],
            ],
            self::ROLE_BRAND => [
                ['key' => 'home',      'label' => 'Home',     'icon' => 'dashboard', 'endpoint' => 'brand/dashboard'],
                ['key' => 'products',  'label' => 'Products', 'icon' => 'box',       'endpoint' => 'brand/products'],
                ['key' => 'scans',     'label' => 'Scans',    'icon' => 'activity',  'endpoint' => 'brand/scans'],
                ['key' => 'alerts',    'label' => 'Alerts',   'icon' => 'bell',      'endpoint' => 'brand/alerts'],
                ['key' => 'profile',   'label' => 'Profile',  'icon' => 'user',      'endpoint' => 'app/me'],
            ],
        ];

        if ($role === self::ROLE_AUTHORITY) {
            return $definitions[self::ROLE_INSPECTOR];
        }

        if ($role === self::ROLE_ADMIN) {
            return $definitions[self::ROLE_BRAND];
        }

        return isset($definitions[$role]) ? $definitions[$role] : $definitions[self::ROLE_CONSUMER];
    }

    protected function quickActions($user)
    {
        $role = $this->role($user);

        switch ($role) {
            case self::ROLE_SUPPLY_CHAIN:
                return [
                    ['key' => 'scan',        'label' => 'Scan a shipment', 'icon' => 'qr_scanner', 'primary' => true],
                    ['key' => 'consignments','label' => 'With me',    'icon' => 'package',    'primary' => false],
                    ['key' => 'history',     'label' => 'Activity',     'icon' => 'route',      'primary' => false],
                ];

            case self::ROLE_INSPECTOR:
            case self::ROLE_AUTHORITY:
                return [
                    ['key' => 'scan',      'label' => 'Verify a product', 'icon' => 'qr_scanner', 'primary' => true],
                    ['key' => 'open_cases','label' => 'Open reports',       'icon' => 'folder',     'primary' => false],
                ];

            case self::ROLE_BRAND:
            case self::ROLE_ADMIN:
                return [
                    ['key' => 'dashboard', 'label' => 'Live stats',    'icon' => 'activity', 'primary' => true],
                    ['key' => 'alerts',    'label' => 'Open alerts',   'icon' => 'bell',     'primary' => false],
                    ['key' => 'products',  'label' => 'My products',   'icon' => 'box',      'primary' => false],
                ];

            default:
                return [
                    ['key' => 'scan',    'label' => 'Scan product', 'icon' => 'qr_scanner', 'primary' => true],
                    ['key' => 'rewards', 'label' => 'My rewards',   'icon' => 'gift',       'primary' => false],
                    ['key' => 'report',  'label' => 'Report a fake','icon' => 'flag',       'primary' => false],
                ];
        }
    }

    protected function scannerConfig($user)
    {
        $role = $this->role($user);

        if ($role === self::ROLE_SUPPLY_CHAIN) {
            return [
                'mode'             => 'supply_chain',
                'submit_endpoint'  => 'supply-chain/scan',
                'requires_location'=> true,
                'hint'             => 'Point at the label on the box or pallet',
            ];
        }

        return [
            'mode'              => 'product',
            'submit_endpoint'   => 'p/{code}',
            'requires_location' => true,
            'hint'              => 'Point the camera at the QR code on the pack',
        ];
    }

    protected function displayName($user)
    {
        $parts = array_filter([$user->first_name, $user->last_name]);

        if (!empty($parts)) {
            return implode(' ', $parts);
        }

        return $user->name ? $user->name : ($user->phone ? $user->phone : 'User');
    }

    protected function greeting()
    {
        $hour = (int) date('G');

        if ($hour < 12) {
            return 'Good morning';
        }

        if ($hour < 17) {
            return 'Good afternoon';
        }

        return 'Good evening';
    }
}
