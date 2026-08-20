<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Api\ApiController;
use App\Models\Alert;
use App\Models\Batch;
use App\Models\Blog;
use App\Models\Code;
use App\Models\Product;
use App\Models\RewardScheme;
use App\Models\ScanHistory;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConsumerController extends ApiController
{
    public function home(Request $request)
    {
        $user = $this->requireUser($request);

        $scans = ScanHistory::where('scanned_by', $user->id);

        $totalScans = (clone $scans)->count();
        $genuine    = (clone $scans)->where('genuine', '1')->count();
        $suspicious = $totalScans - $genuine;

        $reports = Alert::where('scanned_by', $user->id)->where('type', '1');

        $recent = ScanHistory::where('scan_histories.scanned_by', $user->id)
            ->orderBy('scan_histories.created_at', 'DESC')
            ->limit(5)
            ->get();

        $recentItems = [];

        foreach ($recent as $scan) {
            $recentItems[] = $this->scanCard($scan);
        }

        return $this->ok('Home loaded successfully', [
            'stats' => [
                [
                    'key'   => 'total_scans',
                    'label' => 'Products scanned',
                    'value' => $totalScans,
                    'icon'  => 'qr_scanner',
                ],
                [
                    'key'   => 'genuine',
                    'label' => 'Verified genuine',
                    'value' => $genuine,
                    'icon'  => 'shield_check',
                ],
                [
                    'key'   => 'suspicious',
                    'label' => 'Flagged',
                    'value' => $suspicious,
                    'icon'  => 'alert',
                ],
                [
                    'key'   => 'reports',
                    'label' => 'Reports filed',
                    'value' => $reports->count(),
                    'icon'  => 'flag',
                ],
            ],
            'top_reward' => $this->topReward($user->id),
            'recent_scans' => $recentItems,
            'open_reports' => Alert::where('scanned_by', $user->id)
                ->where('type', '1')
                ->where('status', '0')
                ->count(),
            'highlights' => $this->highlights(),
            'offers'     => $this->liveOffers(),
        ]);
    }

    public function scans(Request $request)
    {
        $user = $this->requireUser($request);

        $query = ScanHistory::where('scan_histories.scanned_by', $user->id)
            ->leftJoin('codes', 'codes.id', '=', 'scan_histories.code_id')
            ->leftJoin('products', 'products.id', '=', 'codes.product_id')
            ->select([
                'scan_histories.*',
                'products.name as product_name',
                'products.brand as product_brand',
                'products.image_url as product_image',
                'codes.code_data as code_data',
            ])
            ->orderBy('scan_histories.created_at', 'DESC');

        if ($request->filled('genuine')) {
            $query->where('scan_histories.genuine', $request->input('genuine'));
        }

        if ($request->filled('search')) {
            $query->where('products.name', 'like', '%' . $request->input('search') . '%');
        }

        $self = $this;

        list($items, $meta) = $this->paginate($query, $request, function ($scan) use ($self) {
            return [
                'scan_id'         => $scan->id,
                'code_id'         => $scan->code_id,
                'code_data'       => $scan->code_data,
                'product_name'    => $scan->product_name ? $scan->product_name : 'Unknown product',
                'brand'           => $scan->product_brand,
                'image'           => $self->publicAsset($scan->product_image),
                'genuine'         => $scan->genuine == '1',
                'status_label'    => $scan->genuine == '1' ? 'Genuine' : 'Not verified',
                'scanned_at'      => $self->publicDate($scan->created_at),
                'scanned_ago'     => $self->publicAgo($scan->created_at),
            ];
        });

        return $this->ok('Scan history fetched successfully', [
            'scans' => $items,
        ], ['meta' => $meta]);
    }

    public function scanDetail(Request $request, $scan_id)
    {
        $user = $this->requireUser($request);

        $scan = ScanHistory::where('id', $scan_id)
            ->where('scanned_by', $user->id)
            ->first();

        if (!$scan) {
            return $this->fail('Scan not found.', ['scan' => ['Scan not found']], 404);
        }

        $code = Code::find($scan->code_id);

        if (!$code) {
            return $this->fail('Product details are no longer available.', ['product' => ['Not found']], 404);
        }

        $journey = [];

        if ($code->aggregation_id && $code->getAggregation) {
            $journey = prepareSupplyChainScanHistory(
                $code->getAggregation->unique_id,
                $code->getAggregation->user_id
            );
        }

        return $this->ok('Scan details fetched successfully', [
            'scan' => [
                'scan_id'     => $scan->id,
                'genuine'     => $scan->genuine == '1',
                'scanned_at'  => $this->date($scan->created_at),
                'scanned_ago' => $this->ago($scan->created_at),
                'location'    => $this->json($scan->location, null),
            ],
            'product'  => $this->productPayload($code),
            'journey'  => is_array($journey) ? $journey : [],
            'reported' => Alert::where('scanned_by', $user->id)
                ->where('code_id', $code->id)
                ->where('type', '1')
                ->exists(),
        ]);
    }

    public function report(Request $request)
    {
        $user = $this->requireUser($request);

        $this->validateInput($request, [
            'issue_type'  => 'required|string|max:200',
            'description' => 'required|string|max:2000',
            'code_data'   => 'nullable|string|max:255',
            'product_id'  => 'nullable',
            'batch'       => 'nullable|string|max:200',
            'image'       => 'nullable',
            'photo'       => 'nullable|image|mimes:png,jpg,jpeg|max:8192',
            'scan_id'     => 'nullable|integer',
        ]);

        $code    = null;
        $product = null;
        $batch   = null;

        if ($request->filled('code_data')) {
            $code = Code::where('code_data', $request->input('code_data'))
                ->orWhere('qr_code', $request->input('code_data'))
                ->first();
        }

        if ($code) {
            $product = $code->getProduct;
            $batch   = $code->getBatch;
        } elseif ($request->filled('product_id')) {
            $product = Product::find($request->input('product_id'));
        }

        if (!$batch && $request->filled('batch')) {
            $batch = Batch::where('code', $request->input('batch'))->first();
        }

        if ($product) {
            $duplicate = Alert::where('type', '1')
                ->where('product_id', $product->id)
                ->where('scanned_by', $user->id)
                ->where('status', '0')
                ->exists();

            if ($duplicate) {
                return $this->fail(
                    'You have already reported this product. We are still reviewing it.',
                    ['product' => ['Already reported']],
                    422
                );
            }
        }

        $report = new Alert;
        $report->scanned_by   = $user->id;
        $report->product_id   = $product ? $product->id : null;
        $report->product_name = $product ? $product->name : $request->input('code_data', 'Unknown product');
        $report->batch        = $batch ? $batch->code : $request->input('batch');
        $report->batch_id     = $batch ? $batch->id : null;
        $report->code_id      = $code ? $code->id : null;
        $report->issue_type   = $request->input('issue_type');
        $report->alert_message = $request->input('description');
        $report->type         = '1';
        $report->status       = '0';

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $name = date('Y-m-d-His') . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs('public/reports', $file, $name);
            $report->image = Storage::url('reports/' . $name);
        } elseif ($request->filled('image')) {
            $report->image = $request->input('image');
        }

        if ($request->filled('location')) {
            $location = $request->input('location');
            $report->location = is_string($location) ? $location : json_encode($location);
        }

        $report->save();

        return $this->ok('Thanks — your report has been submitted. We will look into it.', [
            'report' => [
                'id'           => $report->id,
                'reference'    => 'RPT-' . str_pad($report->id, 6, '0', STR_PAD_LEFT),
                'product_name' => $report->product_name,
                'issue_type'   => $report->issue_type,
                'status'       => 'Open',
                'created_at'   => $this->date($report->created_at),
            ],
        ]);
    }

    public function reports(Request $request)
    {
        $user = $this->requireUser($request);

        $query = Alert::where('scanned_by', $user->id)
            ->where('type', '1')
            ->orderBy('created_at', 'DESC');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $self = $this;

        list($items, $meta) = $this->paginate($query, $request, function ($alert) use ($self) {
            return [
                'id'           => $alert->id,
                'reference'    => 'RPT-' . str_pad($alert->id, 6, '0', STR_PAD_LEFT),
                'product_name' => $alert->product_name,
                'batch'        => $alert->batch,
                'issue_type'   => $alert->issue_type,
                'description'  => $alert->alert_message,
                'status'       => $alert->status == '1' ? 'Closed' : 'Open',
                'resolution'   => $alert->status == '1' ? $alert->manufacturer_comment : null,
                'created_at'   => $self->publicDate($alert->created_at),
                'created_ago'  => $self->publicAgo($alert->created_at),
            ];
        });

        return $this->ok('Reports fetched successfully', [
            'reports' => $items,
        ], ['meta' => $meta]);
    }

    public function notifications(Request $request)
    {
        $user = $this->requireUser($request);

        $feed = [];

        $credits = Wallet::where('user_id', $user->id)
            ->where('type', 'credit')
            ->where('status', 'Success')
            ->orderBy('created_at', 'DESC')
            ->limit(25)
            ->get();

        foreach ($credits as $credit) {
            $feed[] = [
                'type'       => 'reward',
                'title'      => 'You earned ' . (float) $credit->points . ' points',
                'body'       => $credit->brand ? 'Credited by ' . $credit->brand : 'Reward points credited to your wallet',
                'icon'       => 'gift',
                'created_at' => $this->date($credit->created_at),
                'created_ago' => $this->ago($credit->created_at),
                'sort'       => strtotime($credit->created_at),
            ];
        }

        $closed = Alert::where('scanned_by', $user->id)
            ->where('type', '1')
            ->orderBy('updated_at', 'DESC')
            ->limit(25)
            ->get();

        foreach ($closed as $alert) {
            $feed[] = [
                'type'       => 'report',
                'title'      => $alert->status == '1'
                    ? 'Your report on ' . $alert->product_name . ' was resolved'
                    : 'Your report on ' . $alert->product_name . ' is under review',
                'body'       => $alert->status == '1'
                    ? ($alert->manufacturer_comment ? $alert->manufacturer_comment : 'The brand has closed this case.')
                    : 'We will notify you as soon as there is an update.',
                'icon'       => $alert->status == '1' ? 'check_circle' : 'clock',
                'created_at' => $this->date($alert->updated_at),
                'created_ago' => $this->ago($alert->updated_at),
                'sort'       => strtotime($alert->updated_at),
            ];
        }

        usort($feed, function ($a, $b) {
            return $b['sort'] - $a['sort'];
        });

        foreach ($feed as $key => $item) {
            unset($feed[$key]['sort']);
        }

        return $this->okList('Notifications fetched successfully', 'notifications', array_values($feed));
    }

    protected function scanCard($scan)
    {
        $code    = Code::find($scan->code_id);
        $product = $code ? $code->getProduct : null;

        return [
            'scan_id'      => $scan->id,
            'code_data'    => $code ? $code->code_data : null,
            'product_name' => $product ? $product->name : 'Unknown product',
            'brand'        => $product ? $product->brand : null,
            'image'        => $product ? $this->assetUrl($product->image_url) : '',
            'genuine'      => $scan->genuine == '1',
            'status_label' => $scan->genuine == '1' ? 'Genuine' : 'Not verified',
            'scanned_at'   => $this->date($scan->created_at),
            'scanned_ago'  => $this->ago($scan->created_at),
        ];
    }

    protected function productPayload($code)
    {
        $product = $code->getProduct;
        $batch   = $code->getBatch;

        if (!$product) {
            return null;
        }

        return [
            'id'              => $product->id,
            'name'            => $product->name,
            'brand'           => $product->brand,
            'description'     => $product->description,
            'price'           => $product->price ? trim($product->currency . ' ' . $product->price) : '',
            'manufacturer'    => $code->getUser && $code->getUser->getCompany ? $code->getUser->getCompany->name : '',
            'code_data'       => $code->code_data,
            'batch_code'      => $batch ? $batch->code : '',
            'manufactured_on' => $batch ? $this->date($batch->mfg_date, 'M d, Y') : '',
            'expiry_on'       => $batch ? $this->date($batch->exp_date, 'M d, Y') : '',
            'is_expired'      => $batch && $batch->exp_date ? strtotime($batch->exp_date) < time() : false,
            'image'           => $this->assetUrl($product->image_url),
            'label_image'     => $this->assetUrl($product->label_image_url),
            'media'           => $this->assetUrl($product->media),
            'logo'            => $this->assetUrl($product->logo),
            'serial_number'   => $code->code_data,
            'gallery'         => $this->productGallery($product),
            'scan_count'      => $this->consumerScanCount($code->id),
        ];
    }

    protected function productGallery($product)
    {
        $images = [];

        foreach (['image_url', 'label_image_url', 'logo'] as $field) {
            $value = isset($product->{$field}) ? $product->{$field} : null;

            if (!empty($value)) {
                $url = $this->assetUrl($value);

                if ($url !== '' && !in_array($url, $images, true)) {
                    $images[] = $url;
                }
            }
        }

        return $images;
    }

    protected function brandBalances($user_id)
    {
        $brands = Wallet::where('user_id', $user_id)
            ->where('status', 'Success')
            ->whereNotNull('brand')
            ->distinct()
            ->pluck('brand');

        $result = [];

        foreach ($brands as $brand) {
            $result[] = [
                'brand'  => $brand,
                'points' => (float) getWalletBalance($user_id, $brand),
            ];
        }

        return $result;
    }

    /**
     * Points live inside one reward scheme and cannot be pooled, so the home
     * screen leads with the shopper's strongest single reward instead of a
     * combined total they could never spend.
     */
    protected function topReward($userId)
    {
        try {
            $schemeIds = Wallet::where('user_id', $userId)
                ->where('status', 'Success')
                ->whereNotNull('reward_id')
                ->distinct()
                ->pluck('reward_id')
                ->toArray();
        } catch (\Exception $e) {
            return null;
        }

        $best = null;

        foreach ($schemeIds as $schemeId) {
            $credit = (float) Wallet::where('user_id', $userId)
                ->where('reward_id', $schemeId)
                ->where('type', 'credit')
                ->where('status', 'Success')
                ->sum('points');

            $debit = (float) Wallet::where('user_id', $userId)
                ->where('reward_id', $schemeId)
                ->where('type', 'debit')
                ->where('status', 'Success')
                ->sum('points');

            $points = $credit - $debit;

            if ($points <= 0) {
                continue;
            }

            if ($best === null || $points > $best['points']) {
                $scheme = RewardScheme::find($schemeId);

                $best = [
                    'scheme_id' => $schemeId,
                    'title'     => $scheme && $scheme->title ? $scheme->title : 'Reward',
                    'points'    => $points,
                ];
            }
        }

        if ($best === null) {
            return null;
        }

        $best['reward_count'] = count($schemeIds);

        return $best;
    }

    /**
     * Reward schemes running right now. This is the hook that gets a shopper
     * to scan, so it sits at the top of the home screen.
     */
    protected function liveOffers()
    {
        $today = date('Y-m-d');

        try {
            $schemes = RewardScheme::where('status', 'Active')
                ->where(function ($q) use ($today) {
                    $q->whereNull('from')->orWhereDate('from', '<=', $today);
                })
                ->where(function ($q) use ($today) {
                    $q->whereNull('to')->orWhereDate('to', '>=', $today);
                })
                ->orderBy('created_at', 'DESC')
                ->limit(8)
                ->get();
        } catch (\Exception $e) {
            return [];
        }

        $offers = [];

        foreach ($schemes as $scheme) {
            $product = $scheme->product_id ? Product::find($scheme->product_id) : null;

            $endsIn = null;

            if (!empty($scheme->to)) {
                $days = (int) floor((strtotime($scheme->to) - strtotime($today)) / 86400);
                $endsIn = $days < 0 ? 0 : $days;
            }

            $offers[] = [
                'scheme_id'    => $scheme->id,
                'title'        => $scheme->title ?: 'Scan and win',
                'points'       => (float) $scheme->points,
                'product_name' => $product ? $product->name : null,
                'brand'        => $product ? $product->brand : null,
                'image'        => $product ? $this->assetUrl($product->image_url) : '',
                'valid_to'     => !empty($scheme->to) ? $this->date($scheme->to, 'M d, Y') : null,
                'ends_in_days' => $endsIn,
            ];
        }

        return $offers;
    }

    protected function highlights()
    {
        $items = [];

        try {
            $blogs = Blog::where('status', 1)->orderBy('created_at', 'DESC')->limit(5)->get();

            foreach ($blogs as $blog) {
                $items[] = [
                    'id'           => $blog->id,
                    'title'        => $blog->title,
                    'image'        => $this->assetUrl($blog->image_path),
                    'excerpt'      => limit_text(strip_tags($blog->description), 18),
                    'publish_date' => $this->date($blog->publish_date, 'M d, Y'),
                ];
            }
        } catch (\Exception $e) {
            return [];
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
}
