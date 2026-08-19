<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Api\ApiController;
use App\Models\Aggregation;
use App\Models\Alert;
use App\Models\Batch;
use App\Models\Code;
use App\Models\Product;
use App\Models\ScanHistory;
use App\Models\SupplyChain;
use App\Models\SupplyChainAction;
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

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('products.name', 'like', '%' . $search . '%')
                  ->orWhere('codes.code_data', 'like', '%' . $search . '%');
            });
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
                'image'        => $self->publicAsset($alert->image),
                'code'         => $self->alertCode($alert),
                'raised_by'    => $self->alertRaiser($alert),
                'resolution'   => (string) $alert->status === '1'
                    ? ($alert->manufacturer_comment ?: $alert->admin_comment)
                    : null,
                'created_at'   => $self->publicDate($alert->created_at),
                'created_ago'  => $self->publicAgo($alert->created_at),
            ];
        });

        return $this->ok('Alerts fetched successfully', [
            'alerts' => $items,
        ], ['meta' => $meta]);
    }

    public function lookup(Request $request)
    {
        $user  = $this->requireUser($request);
        $this->requireRole($user, [self::ROLE_BRAND, self::ROLE_ADMIN, self::ROLE_AUTHORITY]);

        $owner = $this->ownerId($user);

        $this->validateInput($request, ['code' => 'required|string|max:255']);

        $raw = trim($request->input('code'));

        $code = Code::where('user_id', $owner)
            ->where(function ($q) use ($raw) {
                $q->where('code_data', $raw)->orWhere('qr_code', $raw);
            })
            ->first();

        if (!$code) {
            return $this->fail('That code does not belong to your products.', ['code' => ['Not found']], 404);
        }

        $product = $code->getProduct;
        $batch   = $code->getBatch;

        return $this->ok('Code found', [
            'serial_number' => $code->code_data,
            'is_active'     => (string) $code->status === '1',
            'status_label'  => (string) $code->status === '1' ? 'Active' : 'Deactivated',
            'deactivate_reason' => $code->deactivate_reason,
            'product_name'  => $product ? $product->name : 'Unknown product',
            'product_id'    => $product ? $product->id : null,
            'brand'         => $product ? $product->brand : null,
            'image'         => $product ? $this->assetUrl($product->image_url) : '',
            'batch_code'    => $batch ? $batch->code : null,
            'batch_id'      => $batch ? $batch->id : null,
            'batch_total'   => $batch ? Code::where('batch_id', $batch->id)->count() : 0,
            'batch_active'  => $batch
                ? Code::where('batch_id', $batch->id)->where('status', '1')->count()
                : 0,
        ]);
    }

    public function deactivate(Request $request)
    {
        $user  = $this->requireUser($request);
        $this->requireRole($user, [self::ROLE_BRAND, self::ROLE_ADMIN, self::ROLE_AUTHORITY]);

        $owner = $this->ownerId($user);

        $this->validateInput($request, [
            'scope'  => 'required|in:serial,batch',
            'code'   => 'required|string|max:255',
            'reason' => 'nullable|string|max:200',
        ]);

        $raw   = trim($request->input('code'));
        $scope = $request->input('scope');

        if ($scope === 'serial') {
            $code = Code::where('user_id', $owner)
                ->where(function ($q) use ($raw) {
                    $q->where('code_data', $raw)->orWhere('qr_code', $raw);
                })
                ->first();

            if (!$code) {
                return $this->fail('That code does not belong to your products.', ['code' => ['Not found']], 404);
            }

            if ((string) $code->status === '0') {
                return $this->fail('This serial is already deactivated.', ['code' => ['Already blocked']], 422);
            }

            $code->status            = '0';
            $code->deactivate_reason = $request->input('reason');
            $code->deactivated_at    = now();
            $code->deactivated_by    = $user->id;
            $code->save();

            return $this->ok('This serial has been deactivated. Anyone who scans it will be warned.', [
                'scope'    => 'serial',
                'affected' => 1,
                'serial_number' => $code->code_data,
            ]);
        }

        $code = Code::where('user_id', $owner)
            ->where(function ($q) use ($raw) {
                $q->where('code_data', $raw)->orWhere('qr_code', $raw);
            })
            ->first();

        $batch = $code && $code->getBatch
            ? $code->getBatch
            : Batch::where('code', $raw)->first();

        if (!$batch) {
            return $this->fail('We could not find that batch.', ['code' => ['Batch not found']], 404);
        }

        $affected = Code::where('batch_id', $batch->id)
            ->where('user_id', $owner)
            ->where('status', '1')
            ->update([
                'status'            => '0',
                'deactivate_reason' => $request->input('reason'),
                'deactivated_at'    => now(),
                'deactivated_by'    => $user->id,
            ]);

        if ($affected === 0) {
            return $this->fail('Every pack in this batch is already deactivated.', ['code' => ['Already blocked']], 422);
        }

        return $this->ok($affected . ' packs in batch ' . $batch->code . ' have been deactivated.', [
            'scope'      => 'batch',
            'affected'   => $affected,
            'batch_code' => $batch->code,
        ]);
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

    public function alertCode($alert)
    {
        if (!$alert->code_id) {
            return null;
        }

        $code = Code::find($alert->code_id);

        return $code ? $code->code_data : null;
    }

    public function alertRaiser($alert)
    {
        if (!$alert->scanned_by) {
            return 'System';
        }

        $person = User::find($alert->scanned_by);

        if (!$person) {
            return 'Unknown';
        }

        return $person->name ?: $this->maskPhone($person);
    }

    /**
     * Where a product's stock physically is.
     *
     * Packs live on primary aggregations, but a movement can be recorded on
     * any level above them (pallet, tertiary...). So we resolve each primary
     * group ONCE against the newest action anywhere in its ancestor chain.
     * Counting per aggregation instead would count the same packs again for
     * every level that was scanned.
     */
    public function journey(Request $request, $id)
    {
        $user = $this->requireUser($request);
        $this->requireRole($user, [self::ROLE_BRAND, self::ROLE_ADMIN]);

        $owner = $this->ownerId($user);

        $product = Product::where('id', $id)->where('user_id', $owner)->first();

        if (!$product) {
            return $this->fail('Product not found.', ['product' => ['Not found']], 404);
        }

        $totalCodes  = Code::where('product_id', $product->id)->count();
        $activeCodes = Code::where('product_id', $product->id)->where('status', '1')->count();

        $reachedBuyers = ScanHistory::join('codes', 'codes.id', '=', 'scan_histories.code_id')
            ->join('users', 'users.id', '=', 'scan_histories.scanned_by')
            ->where('codes.product_id', $product->id)
            ->where('users.type', '0')
            ->distinct()
            ->count('codes.id');

        $packsPerAggregation = Code::where('product_id', $product->id)
            ->whereNotNull('aggregation_id')
            ->groupBy('aggregation_id')
            ->selectRaw('aggregation_id, COUNT(*) as total')
            ->pluck('total', 'aggregation_id')
            ->toArray();

        $packed = array_sum($packsPerAggregation);

        if (empty($packsPerAggregation)) {
            return $this->ok('Journey loaded successfully', $this->emptyJourney($product, $totalCodes, $activeCodes, $packed, $reachedBuyers));
        }

        // Load every aggregation we care about plus all its ancestors.
        $map   = [];
        $queue = array_keys($packsPerAggregation);

        while (!empty($queue)) {
            $rows  = Aggregation::whereIn('id', $queue)->get();
            $queue = [];

            foreach ($rows as $row) {
                $map[$row->id] = $row;

                if ($row->parent_id && !isset($map[$row->parent_id])) {
                    $queue[] = $row->parent_id;
                }
            }

            $queue = array_values(array_unique($queue));
        }

        // Ancestor chain of unique ids for each pack-holding aggregation.
        $chains     = [];
        $everyUnique = [];

        foreach (array_keys($packsPerAggregation) as $aggregationId) {
            $chain   = [];
            $current = isset($map[$aggregationId]) ? $map[$aggregationId] : null;
            $guard   = 0;

            while ($current && $guard < 12) {
                $chain[]       = $current->unique_id;
                $everyUnique[] = $current->unique_id;
                $current = $current->parent_id && isset($map[$current->parent_id])
                    ? $map[$current->parent_id]
                    : null;
                $guard++;
            }

            $chains[$aggregationId] = $chain;
        }

        $actions = SupplyChainAction::where('user_id', $owner)
            ->whereIn('aggregation_unique_id', array_values(array_unique($everyUnique)))
            ->orderBy('id', 'ASC')
            ->get();

        $byUnique = [];

        foreach ($actions as $action) {
            $byUnique[$action->aggregation_unique_id][] = $action;
        }

        $names = $this->nodeNames($actions);

        $factory   = $product->getUser && $product->getUser->name
            ? $product->getUser->name
            : 'Factory';

        $inTransit = 0;
        $delivered = 0;
        $atFactory = 0;
        $holders   = [];
        $paths     = [];

        foreach ($chains as $aggregationId => $chain) {
            $packs = isset($packsPerAggregation[$aggregationId]) ? $packsPerAggregation[$aggregationId] : 0;

            $timeline = [];

            foreach ($chain as $uniqueId) {
                if (!isset($byUnique[$uniqueId])) {
                    continue;
                }

                foreach ($byUnique[$uniqueId] as $action) {
                    $timeline[] = $action;
                }
            }

            if (empty($timeline)) {
                $atFactory += $packs;
                continue;
            }

            usort($timeline, function ($a, $b) {
                return $a->id - $b->id;
            });

            // Walk the timeline once to build the human-readable hop list.
            $hops = [$factory];

            foreach ($timeline as $action) {
                $who = (string) $action->action === 'checkout'
                    ? $action->action_for
                    : $action->action_by;

                if (!$who) {
                    continue;
                }

                $label = isset($names[$who]) ? $names[$who] : 'Unknown';

                if (end($hops) !== $label) {
                    $hops[] = $label;
                }
            }

            $last     = end($timeline);
            $isMoving = (string) $last->action === 'checkout';
            $holderId = $isMoving ? $last->action_for : $last->action_by;

            if ($isMoving) {
                $inTransit += $packs;
            } else {
                $delivered += $packs;
            }

            if ($holderId) {
                if (!isset($holders[$holderId])) {
                    $holders[$holderId] = [
                        'name'       => isset($names[$holderId]) ? $names[$holderId] : 'Unknown',
                        'role'       => isset($names['role_' . $holderId]) ? $names['role_' . $holderId] : null,
                        'packs'      => 0,
                        'shipments'  => 0,
                        'in_transit' => 0,
                        'last_at'    => null,
                    ];
                }

                $holders[$holderId]['packs']     += $packs;
                $holders[$holderId]['shipments'] += 1;
                $holders[$holderId]['last_at']    = $last->created_at;

                if ($isMoving) {
                    $holders[$holderId]['in_transit'] += $packs;
                }
            }

            $key = implode(' > ', $hops);

            if (!isset($paths[$key])) {
                $paths[$key] = [
                    'hops'      => $hops,
                    'packs'     => 0,
                    'shipments' => 0,
                    'moving'    => false,
                    'last_at'   => null,
                ];
            }

            $paths[$key]['packs']     += $packs;
            $paths[$key]['shipments'] += 1;
            $paths[$key]['last_at']    = $last->created_at;

            if ($isMoving) {
                $paths[$key]['moving'] = true;
            }
        }

        $self = $this;

        $holderRows = array_values(array_map(function ($row) use ($self) {
            return [
                'name'       => $row['name'],
                'role'       => $row['role'],
                'packs'      => $row['packs'],
                'shipments'  => $row['shipments'],
                'in_transit' => $row['in_transit'],
                'state'      => $row['in_transit'] > 0 ? 'On the way' : 'Holding',
                'last_ago'   => $self->publicAgo($row['last_at']),
            ];
        }, $holders));

        usort($holderRows, function ($a, $b) {
            return $b['packs'] - $a['packs'];
        });

        $pathRows = array_values(array_map(function ($row) use ($self) {
            return [
                'hops'      => $row['hops'],
                'packs'     => $row['packs'],
                'shipments' => $row['shipments'],
                'moving'    => $row['moving'],
                'last_ago'  => $self->publicAgo($row['last_at']),
            ];
        }, $paths));

        usort($pathRows, function ($a, $b) {
            return $b['packs'] - $a['packs'];
        });

        return $this->ok('Journey loaded successfully', [
            'product' => [
                'id'    => $product->id,
                'name'  => $product->name,
                'brand' => $product->brand,
                'image' => $this->assetUrl($product->image_url),
            ],
            'stages' => [
                ['key' => 'made',      'label' => 'Made',       'value' => $totalCodes,     'icon' => 'factory'],
                ['key' => 'packed',    'label' => 'Packed',     'value' => $packed,         'icon' => 'package'],
                ['key' => 'moving',    'label' => 'On the way', 'value' => $inTransit,      'icon' => 'truck'],
                ['key' => 'delivered', 'label' => 'Received',   'value' => $delivered,      'icon' => 'download'],
                ['key' => 'buyers',    'label' => 'Bought',     'value' => $reachedBuyers,  'icon' => 'people'],
            ],
            'at_factory'    => $atFactory,
            'holders'       => $holderRows,
            'paths'         => $pathRows,
            'active_codes'  => $activeCodes,
            'blocked_codes' => $totalCodes - $activeCodes,
        ]);
    }

    protected function emptyJourney($product, $totalCodes, $activeCodes, $packed = 0, $reachedBuyers = 0)
    {
        return [
            'product' => [
                'id'    => $product->id,
                'name'  => $product->name,
                'brand' => $product->brand,
                'image' => $this->assetUrl($product->image_url),
            ],
            'stages' => [
                ['key' => 'made',      'label' => 'Made',       'value' => $totalCodes,    'icon' => 'factory'],
                ['key' => 'packed',    'label' => 'Packed',     'value' => $packed,        'icon' => 'package'],
                ['key' => 'moving',    'label' => 'On the way', 'value' => 0,              'icon' => 'truck'],
                ['key' => 'delivered', 'label' => 'Received',   'value' => 0,              'icon' => 'download'],
                ['key' => 'buyers',    'label' => 'Bought',     'value' => $reachedBuyers, 'icon' => 'people'],
            ],
            'at_factory'    => $packed,
            'holders'       => [],
            'paths'         => [],
            'active_codes'  => $activeCodes,
            'blocked_codes' => $totalCodes - $activeCodes,
        ];
    }

    protected function nodeNames($actions)
    {
        $ids = [];

        foreach ($actions as $action) {
            if ($action->action_by)  $ids[] = $action->action_by;
            if ($action->action_for) $ids[] = $action->action_for;
        }

        $names = [];

        if (empty($ids)) {
            return $names;
        }

        $users = User::whereIn('id', array_unique($ids))->get();

        foreach ($users as $person) {
            $names[$person->id] = $person->name ?: 'Unknown';
            $names['role_' . $person->id] = $person->who_you_are;
        }

        return $names;
    }

}
