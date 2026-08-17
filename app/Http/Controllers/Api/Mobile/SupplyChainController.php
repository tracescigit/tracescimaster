<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Api\ApiController;
use App\Models\Aggregation;
use App\Models\SupplyChain;
use App\Models\SupplyChainAction;
use App\Models\SupplyChainAlert;
use App\Models\SupplyChainScanHistory;
use App\Models\SuppplyChainStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplyChainController extends ApiController
{
    public function dashboard(Request $request)
    {
        $user  = $this->requireUser($request);
        $this->requireRole($user, [self::ROLE_SUPPLY_CHAIN, self::ROLE_BRAND, self::ROLE_ADMIN]);

        $owner = $this->ownerId($user);

        $inCustody  = $this->custodyQuery($owner, 'in_custody', $user->id)->count();
        $incoming   = $this->custodyQuery($owner, 'incoming', $user->id)->count();
        $dispatched = $this->custodyQuery($owner, 'dispatched', $user->id)->count();

        $scansToday = SupplyChainScanHistory::where('scanned_by', $user->id)
            ->whereDate('created_at', date('Y-m-d'))
            ->count();

        $recent = SupplyChainAction::where('user_id', $owner)
            ->where(function ($q) use ($user) {
                $q->where('action_by', $user->id)->orWhere('action_for', $user->id);
            })
            ->orderBy('created_at', 'DESC')
            ->limit(8)
            ->get();

        $activity = [];

        foreach ($recent as $action) {
            $activity[] = $this->activityRow($action, $user);
        }

        return $this->ok('Dashboard loaded successfully', [
            'stats' => [
                [
                    'key'   => 'in_custody',
                    'label' => 'With me',
                    'value' => $inCustody,
                    'icon'  => 'package',
                    'filter' => 'in_custody',
                ],
                [
                    'key'   => 'incoming',
                    'label' => 'To receive',
                    'value' => $incoming,
                    'icon'  => 'download',
                    'filter' => 'incoming',
                ],
                [
                    'key'   => 'dispatched',
                    'label' => 'Sent by me',
                    'value' => $dispatched,
                    'icon'  => 'truck',
                    'filter' => 'dispatched',
                ],
                [
                    'key'   => 'scans_today',
                    'label' => 'Scanned today',
                    'value' => $scansToday,
                    'icon'  => 'qr_scanner',
                    'filter' => null,
                ],
            ],
            'alerts_open'  => SupplyChainAlert::where('user_id', $owner)->count(),
            'activity'     => $activity,
            'can_dispatch' => count($this->counterparties($user)) > 0,
        ]);
    }

    public function consignments(Request $request)
    {
        $user  = $this->requireUser($request);
        $this->requireRole($user, [self::ROLE_SUPPLY_CHAIN, self::ROLE_BRAND, self::ROLE_ADMIN]);

        $owner  = $this->ownerId($user);
        $status = $request->input('status', 'all');

        $query = $this->custodyQuery($owner, $status, $user->id)->orderBy('created_at', 'DESC');

        if ($request->filled('search')) {
            $query->where('aggregation_unique_id', 'like', '%' . $request->input('search') . '%');
        }

        $self = $this;
        $me   = $user;

        list($items, $meta) = $this->paginate($query, $request, function ($action) use ($self, $me) {
            return $self->consignmentCard($action, $me);
        });

        return $this->ok('Consignments fetched successfully', [
            'status'       => $status,
            'consignments' => $items,
        ], ['meta' => $meta]);
    }

    public function consignment(Request $request, $unique_id)
    {
        $user  = $this->requireUser($request);
        $this->requireRole($user, [self::ROLE_SUPPLY_CHAIN, self::ROLE_BRAND, self::ROLE_ADMIN]);

        $owner = $this->ownerId($user);

        $aggregation = Aggregation::where('user_id', $owner)->where('unique_id', $unique_id)->first();

        if (!$aggregation) {
            return $this->fail('This code does not belong to your network.', ['code' => ['Unknown code']], 404);
        }

        $codes    = $this->codesInside($aggregation, $owner);
        $products = $this->summariseProducts($codes);

        $last = SupplyChainAction::where('user_id', $owner)
            ->where('aggregation_unique_id', $unique_id)
            ->orderBy('created_at', 'DESC')
            ->first();

        $timeline = prepareSupplyChainScanHistory($unique_id, $owner);

        if (empty($timeline) && $aggregation->parent_id) {
            $parent = Aggregation::find($aggregation->parent_id);

            if ($parent) {
                $timeline = prepareSupplyChainScanHistory($parent->unique_id, $owner);
            }
        }

        return $this->ok('Consignment fetched successfully', [
            'code'          => $unique_id,
            'level'         => ucfirst($aggregation->level),
            'total_units'   => count($codes),
            'child_count'   => $aggregation->getChildren()->count(),
            'products'      => $products,
            'custody'       => $this->custodyLabel($last, $user),
            'last_action'   => $last ? $this->activityRow($last, $user) : null,
            'eligible_for'  => $this->eligibleAction($last, $user),
            'timeline'      => is_array($timeline) ? $timeline : [],
        ]);
    }

    public function timeline(Request $request, $unique_id)
    {
        $user  = $this->requireUser($request);
        $owner = $this->ownerId($user);

        $aggregation = Aggregation::where('user_id', $owner)->where('unique_id', $unique_id)->first();

        if (!$aggregation) {
            return $this->fail('This code does not belong to your network.', ['code' => ['Unknown code']], 404);
        }

        $timeline = prepareSupplyChainScanHistory($unique_id, $owner);

        if (empty($timeline) && $aggregation->parent_id) {
            $parent = Aggregation::find($aggregation->parent_id);

            if ($parent) {
                $timeline = prepareSupplyChainScanHistory($parent->unique_id, $owner);
            }
        }

        return $this->okList('Timeline fetched successfully', 'timeline', is_array($timeline) ? $timeline : []);
    }

    public function counterpartyList(Request $request)
    {
        $user = $this->requireUser($request);
        $this->requireRole($user, [self::ROLE_SUPPLY_CHAIN, self::ROLE_BRAND, self::ROLE_ADMIN]);

        return $this->okList('Counterparties fetched successfully', 'users', $this->counterparties($user));
    }

    public function statuses(Request $request)
    {
        $this->requireUser($request);

        $items = [];

        foreach (SuppplyChainStatus::get() as $status) {
            $items[] = [
                'label'   => $status->status,
                'value'   => $status->status,
                'comment' => $status->placeholder,
            ];
        }

        return $this->okList('Statuses fetched successfully', 'statuses', $items);
    }

    public function alerts(Request $request)
    {
        $user  = $this->requireUser($request);
        $this->requireRole($user, [self::ROLE_SUPPLY_CHAIN, self::ROLE_BRAND, self::ROLE_ADMIN]);

        $owner = $this->ownerId($user);

        $query = SupplyChainAlert::where('user_id', $owner)->orderBy('created_at', 'DESC');

        $self = $this;

        list($items, $meta) = $this->paginate($query, $request, function ($alert) use ($self) {
            $aggregation = $alert->aggregation_id ? Aggregation::find($alert->aggregation_id) : null;
            $scannedBy   = $alert->scanned_by ? User::find($alert->scanned_by) : null;

            return [
                'id'          => $alert->id,
                'message'     => $alert->alert_message,
                'code'        => $aggregation ? $aggregation->unique_id : null,
                'level'       => $aggregation ? ucfirst($aggregation->level) : null,
                'scanned_by'  => $scannedBy ? $scannedBy->name : null,
                'created_at'  => $self->publicDate($alert->created_at),
                'created_ago' => $self->publicAgo($alert->created_at),
            ];
        });

        return $this->ok('Alerts fetched successfully', [
            'alerts' => $items,
        ], ['meta' => $meta]);
    }

    public function myActivity(Request $request)
    {
        $user  = $this->requireUser($request);
        $owner = $this->ownerId($user);

        $query = SupplyChainAction::where('user_id', $owner)
            ->where(function ($q) use ($user) {
                $q->where('action_by', $user->id)->orWhere('action_for', $user->id);
            })
            ->orderBy('created_at', 'DESC');

        $self = $this;
        $me   = $user;

        list($items, $meta) = $this->paginate($query, $request, function ($action) use ($self, $me) {
            return $self->publicActivityRow($action, $me);
        });

        return $this->ok('Activity fetched successfully', [
            'activity' => $items,
        ], ['meta' => $meta]);
    }

    protected function custodyQuery($owner, $status, $user_id)
    {
        $latest = DB::table('supply_chain_actions')
            ->where('user_id', $owner)
            ->selectRaw('MAX(id) as id')
            ->groupBy('aggregation_unique_id')
            ->pluck('id')
            ->toArray();

        $query = SupplyChainAction::whereIn('id', $latest);

        switch ($status) {
            case 'in_custody':
                $query->where('action', 'checkin')->where('action_by', $user_id);
                break;

            case 'incoming':
                $query->where('action', 'checkout')->where('action_for', $user_id);
                break;

            case 'dispatched':
                $query->where('action', 'checkout')->where('action_by', $user_id);
                break;

            default:
                $query->where(function ($q) use ($user_id) {
                    $q->where('action_by', $user_id)->orWhere('action_for', $user_id);
                });
                break;
        }

        return $query;
    }

    public function consignmentCard($action, $user)
    {
        $aggregation = Aggregation::where('unique_id', $action->aggregation_unique_id)
            ->where('user_id', $action->user_id)
            ->first();

        $counterparty = $action->action === 'checkout'
            ? ($action->action_for ? optional(User::find($action->action_for))->name : null)
            : ($action->action_by ? optional(User::find($action->action_by))->name : null);

        return [
            'code'         => $action->aggregation_unique_id,
            'level'        => $aggregation ? ucfirst($aggregation->level) : '',
            'custody'      => $this->custodyLabel($action, $user),
            'action'       => ucfirst($action->action),
            'counterparty' => $counterparty,
            'status'       => $action->status,
            'comment'      => $action->comment,
            'eligible_for' => $this->eligibleAction($action, $user),
            'updated_at'   => $this->date($action->created_at),
            'updated_ago'  => $this->ago($action->created_at),
        ];
    }

    protected function activityRow($action, $user)
    {
        $by  = $action->action_by ? User::find($action->action_by) : null;
        $for = $action->action_for ? User::find($action->action_for) : null;

        $title = $action->action === 'checkout'
            ? 'Dispatched to ' . ($for ? $for->name : 'next node')
            : 'Received from ' . ($by && $by->id !== $user->id ? $by->name : 'previous node');

        if ($action->action === 'checkout' && $action->action_by == $user->id) {
            $title = 'You dispatched to ' . ($for ? $for->name : 'next node');
        }

        if ($action->action === 'checkin' && $action->action_by == $user->id) {
            $title = 'You received ' . $action->aggregation_unique_id;
        }

        return [
            'code'        => $action->aggregation_unique_id,
            'action'      => ucfirst($action->action),
            'title'       => $title,
            'status'      => $action->status,
            'comment'     => $action->comment,
            'by'          => $by ? $by->name : null,
            'for'         => $for ? $for->name : null,
            'verified'    => !empty($action->block_hash),
            'created_at'  => $this->date($action->created_at),
            'created_ago' => $this->ago($action->created_at),
        ];
    }

    public function publicActivityRow($action, $user)
    {
        return $this->activityRow($action, $user);
    }

    protected function custodyLabel($action, $user)
    {
        if (!$action) {
            return 'Not sent yet';
        }

        if ($action->action === 'checkin' && $action->action_by == $user->id) {
            return 'With you';
        }

        if ($action->action === 'checkout' && $action->action_for == $user->id) {
            return 'Coming to you';
        }

        if ($action->action === 'checkout' && $action->action_by == $user->id) {
            return 'You sent this';
        }

        return $action->action === 'checkout' ? 'In transit' : 'Delivered';
    }

    protected function eligibleAction($action, $user)
    {
        if (!$action) {
            return 'checkout';
        }

        if ($action->action === 'checkout' && $action->action_for == $user->id) {
            return 'checkin';
        }

        if ($action->action === 'checkin' && $action->action_by == $user->id) {
            return 'checkout';
        }

        return '';
    }

    protected function counterparties($user)
    {
        $list = [];

        $children = SupplyChain::where('supply_chain_parent_id', $user->id)->get();

        foreach ($children as $child) {
            if (!$child->getUser) {
                continue;
            }

            $list[] = [
                'label'     => $child->getUser->name,
                'value'     => $child->getUser->id,
                'role'      => $child->getUser->who_you_are,
                'direction' => 'downstream',
            ];
        }

        $me = SupplyChain::where('user_id', $user->id)->first();

        if ($me && $me->supply_chain_parent_id) {
            $parent = User::find($me->supply_chain_parent_id);

            if ($parent) {
                $list[] = [
                    'label'     => $parent->name,
                    'value'     => $parent->id,
                    'role'      => $parent->who_you_are,
                    'direction' => 'return',
                ];
            }
        }

        return $list;
    }

    protected function codesInside($aggregation, $owner, $codes = [])
    {
        if (!$aggregation) {
            return $codes;
        }

        if (strtolower($aggregation->level) === 'primary') {
            foreach ($aggregation->getCodes as $code) {
                $codes[] = $code;
            }

            return $codes;
        }

        foreach ($aggregation->getChildren as $child) {
            $codes = $this->codesInside($child, $owner, $codes);
        }

        return $codes;
    }

    protected function summariseProducts($codes)
    {
        $grouped = [];

        foreach ($codes as $code) {
            $product = $code->getProduct;
            $batch   = $code->getBatch;

            $key = ($product ? $product->id : '0') . '-' . ($batch ? $batch->id : '0');

            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'name'            => $product ? $product->name : 'Unknown product',
                    'brand'           => $product ? $product->brand : null,
                    'image'           => $product ? $this->assetUrl($product->image_url) : '',
                    'batch_code'      => $batch ? $batch->code : '',
                    'manufactured_on' => $batch ? $this->date($batch->mfg_date, 'M d, Y') : '',
                    'expiry_on'       => $batch ? $this->date($batch->exp_date, 'M d, Y') : '',
                    'is_expired'      => $batch && $batch->exp_date ? strtotime($batch->exp_date) < time() : false,
                    'quantity'        => 0,
                ];
            }

            $grouped[$key]['quantity']++;
        }

        return array_values($grouped);
    }

    public function publicDate($value, $format = 'M d, Y h:i a')
    {
        return $this->date($value, $format);
    }

    public function publicAgo($value)
    {
        return $this->ago($value);
    }
}
