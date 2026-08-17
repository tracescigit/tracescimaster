<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Api\ApiController;
use App\Models\Alert;
use App\Models\Batch;
use App\Models\Code;
use App\Models\Product;
use App\Models\ScanHistory;
use App\Models\SupplyChain;
use App\Models\SupplyChainAlert;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends ApiController
{
    public function dashboard(Request $request)
    {
        $user = $this->requireUser($request);
        $this->requireRole($user, [self::ROLE_BRAND, self::ROLE_ADMIN, self::ROLE_AUTHORITY]);

        $owner = $this->ownerId($user);

        $qr = getTotalQR($owner);

        return $this->ok('Dashboard loaded successfully', [
            'stats' => [
                ['key' => 'products',  'label' => 'Products',       'value' => getTotalProducts($owner),    'icon' => 'box'],
                ['key' => 'codes',     'label' => 'Codes generated','value' => getCodesGenerated($owner),   'icon' => 'qr_code'],
                ['key' => 'scans',     'label' => 'Total scans',    'value' => totalScans($owner),          'icon' => 'activity'],
                ['key' => 'alerts',    'label' => 'Open alerts',    'value' => totalAlerts($owner),         'icon' => 'alert'],
            ],
            'this_month' => [
                'codes_uploaded'  => isset($qr['total']) ? $qr['total'] : 0,
                'codes_active'    => isset($qr['active']) ? $qr['active'] : 0,
                'codes_inactive'  => isset($qr['inactive']) ? $qr['inactive'] : 0,
                'activated_today' => isset($qr['activated_today']) ? $qr['activated_today'] : 0,
                'scans'           => totalScans($owner, 'month'),
            ],
            'credits' => [
                'available' => getAvailableCredits($owner),
                'used'      => getUsedCredits($owner),
                'total'     => getCreditAmount($owner),
            ],
            'scan_trend'      => $this->scanTrend($owner),
            'top_products'    => $this->topProducts($owner),
            'recent_alerts'   => $this->recentAlerts($owner),
            'supply_chain'    => [
                'nodes'  => User::where('parent_id', $owner)->where('type', '5')->count(),
                'alerts' => SupplyChainAlert::where('user_id', $owner)->count(),
            ],
        ]);
    }

    public function products(Request $request)
    {
        $user  = $this->requireUser($request);
        $this->requireRole($user, [self::ROLE_BRAND, self::ROLE_ADMIN, self::ROLE_AUTHORITY]);

        $owner = $this->ownerId($user);

        $query = Product::where('user_id', $owner)->orderBy('created_at', 'DESC');

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('brand', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $self = $this;

        list($items, $meta) = $this->paginate($query, $request, function ($product) use ($self) {
            return $self->publicProductCard($product);
        });

        return $this->ok('Products fetched successfully', [
            'products' => $items,
        ], ['meta' => $meta]);
    }

    public function product(Request $request, $id)
    {
        $user  = $this->requireUser($request);
        $this->requireRole($user, [self::ROLE_BRAND, self::ROLE_ADMIN, self::ROLE_AUTHORITY]);

        $owner = $this->ownerId($user);

        $product = Product::where('id', $id)->where('user_id', $owner)->first();

        if (!$product) {
            return $this->fail('Product not found.', ['product' => ['Product not found']], 404);
        }

        $batches = [];

        foreach (Batch::where('product_id', $product->id)->orderBy('created_at', 'DESC')->get() as $batch) {
            $batches[] = [
                'id'              => $batch->id,
                'code'            => $batch->code,
                'gs1_code'        => $batch->gs1_code,
                'manufactured_on' => $this->date($batch->mfg_date, 'M d, Y'),
                'expiry_on'       => $this->date($batch->exp_date, 'M d, Y'),
                'is_expired'      => $batch->exp_date ? strtotime($batch->exp_date) < time() : false,
                'status'          => $batch->status === '1' ? 'Active' : 'Inactive',
                'codes'           => Code::where('batch_id', $batch->id)->count(),
                'remarks'         => $batch->remarks,
            ];
        }

        $codeIds = Code::where('product_id', $product->id)->pluck('id');

        return $this->ok('Product fetched successfully', [
            'product' => array_merge($this->productCard($product), [
                'description'  => $product->description,
                'custom_text'  => $product->custom_text,
                'label_image'  => $this->assetUrl($product->label_image_url),
                'media'        => $this->assetUrl($product->media),
                'logo'         => $this->assetUrl($product->logo),
                'auth_required' => $product->auth_required === '1',
                'pin_required'  => (int) $product->pin_required === 1,
            ]),
            'batches' => $batches,
            'performance' => [
                'codes_generated' => count($codeIds),
                'codes_active'    => Code::where('product_id', $product->id)->where('status', '1')->count(),
                'total_scans'     => ScanHistory::whereIn('code_id', $codeIds)->count(),
                'open_alerts'     => Alert::where('product_id', $product->id)->where('status', '0')->count(),
            ],
        ]);
    }

    public function scans(Request $request)
    {
        $user  = $this->requireUser($request);
        $this->requireRole($user, [self::ROLE_BRAND, self::ROLE_ADMIN, self::ROLE_AUTHORITY]);

        $owner = $this->ownerId($user);

        $query = ScanHistory::leftJoin('codes', 'codes.id', '=', 'scan_histories.code_id')
            ->leftJoin('products', 'products.id', '=', 'codes.product_id')
            ->leftJoin('users', 'users.id', '=', 'scan_histories.scanned_by')
            ->where('codes.user_id', $owner)
            ->select([
                'scan_histories.*',
                'products.name as product_name',
                'products.brand as product_brand',
                'products.image_url as product_image',
                'codes.code_data as code_data',
                'users.name as scanner_name',
                'users.phone as scanner_phone',
                'users.phone_code as scanner_phone_code',
            ])
            ->orderBy('scan_histories.created_at', 'DESC');

        if ($request->filled('product_id')) {
            $query->where('codes.product_id', $request->input('product_id'));
        }

        if ($request->filled('genuine')) {
            $query->where('scan_histories.genuine', $request->input('genuine'));
        }

        $self = $this;

        list($items, $meta) = $this->paginate($query, $request, function ($scan) use ($self) {
            return [
                'scan_id'      => $scan->id,
                'code_data'    => $scan->code_data,
                'product_name' => $scan->product_name,
                'brand'        => $scan->product_brand,
                'image'        => $self->publicAsset($scan->product_image),
                'genuine'      => $scan->genuine == '1',
                'scanned_by'   => $scan->scanner_name
                    ? $scan->scanner_name
                    : trim($scan->scanner_phone_code . ' ' . $scan->scanner_phone),
                'location'     => $self->publicJson($scan->location),
                'scanned_at'   => $self->publicDate($scan->created_at),
                'scanned_ago'  => $self->publicAgo($scan->created_at),
            ];
        });

        return $this->ok('Scans fetched successfully', [
            'scans' => $items,
        ], ['meta' => $meta]);
    }

    public function alerts(Request $request)
    {
        $user  = $this->requireUser($request);
        $this->requireRole($user, [self::ROLE_BRAND, self::ROLE_ADMIN, self::ROLE_AUTHORITY]);

        $owner = $this->ownerId($user);

        $productIds = Product::where('user_id', $owner)->pluck('id');

        $query = Alert::where(function ($q) use ($productIds, $owner) {
            $q->whereIn('product_id', $productIds)
              ->orWhere('manufacturer_assigned_to', $owner)
              ->orWhere('vendor_assigned_to', $owner);
        })->orderBy('created_at', 'DESC');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        $self = $this;

        list($items, $meta) = $this->paginate($query, $request, function ($alert) use ($self) {
            return [
                'id'           => $alert->id,
                'reference'    => ($alert->type === '1' ? 'RPT-' : 'ALT-') . str_pad($alert->id, 6, '0', STR_PAD_LEFT),
                'kind'         => $alert->type === '1' ? 'Consumer report' : 'System alert',
                'product_name' => $alert->product_name,
                'batch'        => $alert->batch,
                'issue_type'   => $alert->issue_type,
                'description'  => $alert->alert_message,
                'status'       => $alert->status === '1' ? 'Closed' : 'Open',
                'location'     => $self->publicJson($alert->location),
                'created_at'   => $self->publicDate($alert->created_at),
                'created_ago'  => $self->publicAgo($alert->created_at),
            ];
        });

        return $this->ok('Alerts fetched successfully', [
            'alerts' => $items,
        ], ['meta' => $meta]);
    }

    public function network(Request $request)
    {
        $user  = $this->requireUser($request);
        $this->requireRole($user, [self::ROLE_BRAND, self::ROLE_ADMIN, self::ROLE_AUTHORITY]);

        $owner = $this->ownerId($user);

        $members = User::where('parent_id', $owner)->where('type', '5')->orderBy('name')->get();

        $nodes = [];

        foreach ($members as $member) {
            $link = SupplyChain::where('user_id', $member->id)->first();

            $nodes[] = [
                'id'        => $member->id,
                'name'      => $member->name,
                'role'      => $member->who_you_are,
                'phone'     => trim($member->phone_code . ' ' . $member->phone),
                'email'     => $member->email,
                'status'    => $member->status === '1' ? 'Active' : 'Inactive',
                'parent_id' => $link ? $link->supply_chain_parent_id : null,
                'joined_on' => $this->date($member->created_at, 'M d, Y'),
            ];
        }

        return $this->okList('Network fetched successfully', 'nodes', $nodes);
    }

    public function scanMap(Request $request)
    {
        $user  = $this->requireUser($request);
        $this->requireRole($user, [self::ROLE_BRAND, self::ROLE_ADMIN, self::ROLE_AUTHORITY]);

        $owner = $this->ownerId($user);

        $scans = ScanHistory::leftJoin('codes', 'codes.id', '=', 'scan_histories.code_id')
            ->leftJoin('products', 'products.id', '=', 'codes.product_id')
            ->where('codes.user_id', $owner)
            ->whereNotNull('scan_histories.location')
            ->select(['scan_histories.location', 'scan_histories.created_at', 'scan_histories.genuine', 'products.name as product_name'])
            ->orderBy('scan_histories.created_at', 'DESC')
            ->limit(500)
            ->get();

        $points = [];

        foreach ($scans as $scan) {
            $location = $this->json($scan->location, null);

            if (!is_array($location)) {
                continue;
            }

            $lat = isset($location['latitude']) ? $location['latitude'] : (isset($location['lat']) ? $location['lat'] : null);
            $lng = isset($location['longitude']) ? $location['longitude'] : (isset($location['lng']) ? $location['lng'] : null);

            if ($lat === null || $lng === null) {
                continue;
            }

            $points[] = [
                'latitude'  => (float) $lat,
                'longitude' => (float) $lng,
                'title'     => $scan->product_name,
                'genuine'   => $scan->genuine == '1',
                'date'      => $this->date($scan->created_at, 'M d, Y'),
            ];
        }

        return $this->okList('Scan map fetched successfully', 'points', $points);
    }

    public function productCard($product)
    {
        return [
            'id'         => $product->id,
            'name'       => $product->name,
            'brand'      => $product->brand,
            'price'      => $product->price ? trim($product->currency . ' ' . $product->price) : '',
            'image'      => $this->assetUrl($product->image_url),
            'status'     => $product->status === '1' ? 'Active' : 'Inactive',
            'is_active'  => $product->status === '1',
            'codes'      => Code::where('product_id', $product->id)->count(),
            'batches'    => Batch::where('product_id', $product->id)->count(),
            'created_at' => $this->date($product->created_at, 'M d, Y'),
        ];
    }

    public function publicProductCard($product)
    {
        return $this->productCard($product);
    }

    protected function scanTrend($owner)
    {
        $trend = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = date('Y-m-d', strtotime('-' . $i . ' days'));

            $count = ScanHistory::leftJoin('codes', 'codes.id', '=', 'scan_histories.code_id')
                ->where('codes.user_id', $owner)
                ->whereDate('scan_histories.created_at', $day)
                ->count();

            $trend[] = [
                'date'  => date('M d', strtotime($day)),
                'day'   => date('D', strtotime($day)),
                'count' => $count,
            ];
        }

        return $trend;
    }

    protected function topProducts($owner)
    {
        $rows = ScanHistory::leftJoin('codes', 'codes.id', '=', 'scan_histories.code_id')
            ->leftJoin('products', 'products.id', '=', 'codes.product_id')
            ->where('codes.user_id', $owner)
            ->whereMonth('scan_histories.created_at', date('m'))
            ->select('products.id', 'products.name', 'products.brand', 'products.image_url', DB::raw('COUNT(scan_histories.id) as scan_count'))
            ->groupBy('products.id', 'products.name', 'products.brand', 'products.image_url')
            ->orderBy('scan_count', 'DESC')
            ->limit(5)
            ->get();

        $items = [];

        foreach ($rows as $row) {
            if (!$row->id) {
                continue;
            }

            $items[] = [
                'id'    => $row->id,
                'name'  => $row->name,
                'brand' => $row->brand,
                'image' => $this->assetUrl($row->image_url),
                'scans' => (int) $row->scan_count,
            ];
        }

        return $items;
    }

    protected function recentAlerts($owner)
    {
        $productIds = Product::where('user_id', $owner)->pluck('id');

        $alerts = Alert::whereIn('product_id', $productIds)
            ->where('status', '0')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();

        $items = [];

        foreach ($alerts as $alert) {
            $items[] = [
                'id'           => $alert->id,
                'product_name' => $alert->product_name,
                'description'  => $alert->alert_message,
                'kind'         => $alert->type === '1' ? 'Consumer report' : 'System alert',
                'created_ago'  => $this->ago($alert->created_at),
            ];
        }

        return $items;
    }

    public function publicDate($value, $format = 'M d, Y h:i a')
    {
        return $this->date($value, $format);
    }

    public function publicAgo($value)
    {
        return $this->ago($value);
    }

    public function publicAsset($path)
    {
        return $this->assetUrl($path);
    }

    public function publicJson($value)
    {
        return $this->json($value, null);
    }
}
