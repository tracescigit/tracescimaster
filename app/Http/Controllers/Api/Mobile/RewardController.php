<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Api\ApiController;
use App\Models\Code;
use App\Models\CouponCode;
use App\Models\RewardOrder;
use App\Models\RewardScheme;
use App\Models\ScanHistory;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class RewardController extends ApiController
{
    /**
     * Points are earned per reward scheme and can only be spent inside that
     * scheme, so there is deliberately no combined balance here — adding
     * "10 Diwali points" to "10 Summer points" would be a number the shopper
     * can never actually spend.
     */
    public function summary(Request $request)
    {
        $user = $this->requireUser($request);

        $today = date('Y-m-d');

        // Every scheme this shopper has ever earned in.
        $schemeIds = Wallet::where('user_id', $user->id)
            ->where('status', 'Success')
            ->whereNotNull('reward_id')
            ->distinct()
            ->pluck('reward_id')
            ->toArray();

        $rewards = [];

        foreach ($schemeIds as $schemeId) {
            $scheme = RewardScheme::find($schemeId);

            if (!$scheme) {
                continue;
            }

            $points = $this->schemePoints($user->id, $schemeId);
            $earned = $this->schemeEarned($user->id, $schemeId);

            if ($earned <= 0) {
                continue;
            }

            $rewards[] = $this->rewardCard($scheme, $points, $earned, $today);
        }

        usort($rewards, function ($a, $b) {
            if ($a['my_points'] === $b['my_points']) {
                return 0;
            }
            return $a['my_points'] < $b['my_points'] ? 1 : -1;
        });

        $pending = RewardOrder::where('customer_id', $user->id)
            ->where('dispatch_status', '!=', 'Delivered')
            ->count();

        return $this->ok('Rewards summary fetched successfully', [
            'rewards'        => $rewards,
            'pending_orders' => $pending,
            'scans_rewarded' => Wallet::where('user_id', $user->id)
                ->where('type', 'credit')
                ->where('status', 'Success')
                ->count(),
        ]);
    }

    /**
     * Spendable points inside one scheme. Scanning a second Diwali pack adds
     * to the same figure rather than creating a second pot.
     */
    protected function schemePoints($userId, $schemeId)
    {
        $credit = Wallet::where('user_id', $userId)
            ->where('reward_id', $schemeId)
            ->where('type', 'credit')
            ->where('status', 'Success')
            ->sum('points');

        $debit = Wallet::where('user_id', $userId)
            ->where('reward_id', $schemeId)
            ->where('type', 'debit')
            ->where('status', 'Success')
            ->sum('points');

        $balance = (float) $credit - (float) $debit;

        return $balance > 0 ? $balance : 0;
    }

    protected function schemeEarned($userId, $schemeId)
    {
        return (float) Wallet::where('user_id', $userId)
            ->where('reward_id', $schemeId)
            ->where('type', 'credit')
            ->where('status', 'Success')
            ->sum('points');
    }

    protected function rewardCard($scheme, $points, $earned, $today)
    {
        $product = $scheme->product_id ? Product::find($scheme->product_id) : null;

        $items    = [];
        $ready    = null;
        $next     = null;

        foreach ((array) $this->json($scheme->items, []) as $item) {
            $cost = isset($item['points']) ? (float) $item['points'] : 0;

            if ($cost <= 0) {
                continue;
            }

            $canGet = $points >= $cost;

            $row = [
                'label'      => $this->itemLabel($item),
                'type'       => isset($item['type']) ? $item['type'] : 'product',
                'points'     => $cost,
                'can_redeem' => $canGet,
                'short_by'   => $canGet ? 0 : round($cost - $points, 2),
            ];

            $items[] = $row;

            if ($canGet && ($ready === null || $cost > $ready['points'])) {
                $ready = $row;
            }

            if (!$canGet && ($next === null || $cost < $next['points'])) {
                $next = $row;
            }
        }

        usort($items, function ($a, $b) {
            if ($a['points'] === $b['points']) {
                return 0;
            }
            return $a['points'] < $b['points'] ? -1 : 1;
        });

        $isLive = (string) $scheme->status === 'Active'
            && (empty($scheme->to) || $scheme->to >= $today);

        $target = $next !== null ? $next['points'] : ($ready !== null ? $ready['points'] : 0);

        return [
            'scheme_id'     => $scheme->id,
            'title'         => $scheme->title ?: 'Reward',
            'brand'         => $product ? $product->brand : null,
            'product_name'  => $product ? $product->name : null,
            'image'         => $product ? $this->assetUrl($product->image_url) : '',
            'my_points'     => (float) $points,
            'earned_points' => (float) $earned,
            'is_live'       => $isLive,
            'valid_to'      => !empty($scheme->to) ? $this->date($scheme->to, 'M d, Y') : null,
            'items'         => $items,
            'ready'         => $ready,
            'next'          => $next,
            'progress'      => $target > 0 ? min(1, round($points / $target, 3)) : ($ready ? 1 : 0),
        ];
    }

    public function ledger(Request $request)
    {
        $user = $this->requireUser($request);

        $query = Wallet::where('user_id', $user->id)
            ->where('status', 'Success')
            ->orderBy('created_at', 'DESC');

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('brand')) {
            $query->where('brand', $request->input('brand'));
        }

        $self = $this;

        list($items, $meta) = $this->paginate($query, $request, function ($entry) use ($self) {
            return $self->ledgerRow($entry);
        });

        return $this->ok('Wallet statement fetched successfully', [
            'balance' => (float) getWalletBalance($user->id, $request->input('brand')),
            'entries' => $items,
        ], ['meta' => $meta]);
    }

    public function catalog(Request $request)
    {
        $user = $this->requireUser($request);

        $today = date('Y-m-d');

        $schemes = RewardScheme::where('status', 'Active')
            ->where(function ($q) use ($today) {
                $q->whereNull('from')->orWhereDate('from', '<=', $today);
            })
            ->where(function ($q) use ($today) {
                $q->whereNull('to')->orWhereDate('to', '>=', $today);
            })
            ->orderBy('created_at', 'DESC')
            ->get();

        $response = [];

        foreach ($schemes as $scheme) {
            $brand   = $this->schemeBrand($scheme);
            $balance = $this->schemePoints($user->id, $scheme->id);

            $items = [];

            foreach ((array) $this->json($scheme->items, []) as $item) {
                $points = isset($item['points']) ? (float) $item['points'] : 0;

                $items[] = [
                    'points'     => $points,
                    'type'       => isset($item['type']) ? $item['type'] : 'product',
                    'item'       => isset($item['item']) ? $item['item'] : '',
                    'label'      => $this->itemLabel($item),
                    'can_redeem' => $balance >= $points && $points > 0,
                    'short_by'   => $balance >= $points ? 0 : round($points - $balance, 2),
                ];
            }

            $response[] = [
                'scheme_id'   => $scheme->id,
                'title'       => $scheme->title,
                'brand'       => $brand,
                'points_per_scan' => (float) $scheme->points,
                'valid_from'  => $this->date($scheme->from, 'M d, Y'),
                'valid_to'    => $this->date($scheme->to, 'M d, Y'),
                'balance'     => $balance,
                'items'       => $items,
            ];
        }

        return $this->okList('Reward catalog fetched successfully', 'schemes', $response);
    }

    public function redeemCoupon(Request $request)
    {
        $user = $this->requireUser($request);

        $this->validateInput($request, [
            'coupon_code' => 'required|string|max:100',
            'scan_id'     => 'nullable|integer',
        ]);

        $coupon = CouponCode::where('coupon_code', $request->input('coupon_code'))->first();

        if (!$coupon) {
            return $this->fail('This coupon code is not valid.', ['coupon_code' => ['Invalid coupon code']], 404);
        }

        if ($coupon->status === 'Redeemed') {
            return $this->fail('This coupon has already been redeemed.', ['coupon_code' => ['Already redeemed']], 422);
        }

        $scheme = RewardScheme::where('id', $coupon->reward_id)->where('status', 'Active')->first();

        if (!$scheme) {
            return $this->fail('The reward scheme for this coupon is no longer active.', ['coupon_code' => ['Scheme inactive']], 422);
        }

        $code = Code::find($coupon->code_id);

        if (!$code) {
            return $this->fail('The product linked to this coupon could not be found.', ['coupon_code' => ['Invalid coupon']], 422);
        }

        $scan = null;

        if ($request->filled('scan_id')) {
            $scan = ScanHistory::where('id', $request->input('scan_id'))
                ->where('scanned_by', $user->id)
                ->first();
        }

        if (!$scan) {
            $scan = ScanHistory::where('code_id', $code->id)
                ->where('scanned_by', $user->id)
                ->orderBy('created_at', 'DESC')
                ->first();
        }

        if (!$scan) {
            return $this->fail('Please scan the product before redeeming its coupon.', ['scan' => ['Scan required']], 422);
        }

        $brand = $code->getProduct ? $code->getProduct->brand : null;

        $credit = new Wallet;
        $credit->type      = 'credit';
        $credit->user_id   = $user->id;
        $credit->scan_id   = $scan->id;
        $credit->reward_id = $scheme->id;
        $credit->points    = $scheme->points;
        $credit->brand     = $brand;
        $credit->status    = 'Success';
        $credit->save();

        $coupon->status  = 'Redeemed';
        $coupon->user_id = $user->id;
        $coupon->save();

        return $this->ok('Coupon redeemed — ' . (float) $scheme->points . ' points added to your wallet.', [
            'points_added' => (float) $scheme->points,
            'brand'        => $brand,
            'balance'      => (float) $this->schemePoints($user->id, $scheme->id),
            'total_balance' => (float) $this->schemePoints($user->id, $scheme->id),
        ]);
    }

    public function scanToRedeem(Request $request)
    {
        $user = $this->requireUser($request);

        $this->validateInput($request, ['code' => 'required|string|max:255']);

        $raw = trim($request->input('code'));

        $code = Code::where('qr_code', $raw)->orWhere('code_data', $raw)->first();

        if (!$code) {
            return $this->fail('We do not recognise that code.', ['code' => ['Unknown code']], 404);
        }

        $coupon = CouponCode::where('code_id', $code->id)->first();

        if (!$coupon) {
            return $this->fail(
                'This pack does not carry a reward.',
                ['code' => ['No reward on this pack']],
                404
            );
        }

        if ($coupon->status === 'Redeemed') {
            return $this->fail(
                'This reward has already been claimed.',
                ['code' => ['Already claimed']],
                422
            );
        }

        $scheme = RewardScheme::where('id', $coupon->reward_id)
            ->where('status', 'Active')
            ->first();

        if (!$scheme) {
            return $this->fail(
                'The reward on this pack is no longer running.',
                ['code' => ['Scheme inactive']],
                422
            );
        }

        $scan = ScanHistory::where('code_id', $code->id)
            ->where('scanned_by', $user->id)
            ->orderBy('created_at', 'DESC')
            ->first();

        if (!$scan) {
            $scan = new ScanHistory;
            $scan->code_id    = $code->id;
            $scan->scanned_by = $user->id;
            $scan->genuine    = (string) $code->status === '1' ? '1' : '0';
            $scan->save();
        }

        $product = $code->getProduct;
        $brand   = $product ? $product->brand : null;

        $credit = new Wallet;
        $credit->type      = 'credit';
        $credit->user_id   = $user->id;
        $credit->scan_id   = $scan->id;
        $credit->reward_id = $scheme->id;
        $credit->points    = $scheme->points;
        $credit->brand     = $brand;
        $credit->status    = 'Success';
        $credit->save();

        $coupon->status  = 'Redeemed';
        $coupon->user_id = $user->id;
        $coupon->save();

        return $this->ok('You won ' . (float) $scheme->points . ' points!', [
            'points_added'  => (float) $scheme->points,
            'scheme_title'  => $scheme->title,
            'brand'         => $brand,
            'product_name'  => $product ? $product->name : null,
            'product_image' => $product ? $this->assetUrl($product->image_url) : '',
            'balance'       => (float) $this->schemePoints($user->id, $scheme->id),
            'total_balance' => (float) $this->schemePoints($user->id, $scheme->id),
        ]);
    }

    public function redeemCash(Request $request)
    {
        $user = $this->requireUser($request);

        $this->validateInput($request, [
            'scheme_id' => 'required|integer',
            'points'    => 'required|numeric|min:1',
            'upi_id'    => 'required|string|min:5|max:100',
            'brand'     => 'nullable|string|max:150',
        ]);

        $brand  = $request->input('brand');
        $points = (float) $request->input('points');

        $scheme = RewardScheme::where('id', $request->input('scheme_id'))->where('status', 'Active')->first();

        if (!$scheme) {
            return $this->fail('This scheme is no longer available.', ['scheme_id' => ['Scheme inactive']], 422);
        }

        $balance = $this->schemePoints($user->id, $scheme->id);

        if ($balance < $points) {
            return $this->fail(
                'You need ' . round($points - $balance, 2) . ' more points in this reward to claim that.',
                ['points' => ['Insufficient balance']],
                422
            );
        }

        $amount = $this->itemValue($scheme, $points, 'amount');

        if ($amount === null) {
            return $this->fail('No cash reward is configured for these points.', ['points' => ['Invalid slab']], 422);
        }

        $payout = createRazorpayXPayout($request->input('upi_id'), $amount);

        if (!isset($payout['success']) || $payout['success'] === false) {
            return $this->fail(
                isset($payout['message']) ? $payout['message'] : 'Payout could not be processed. Please try again.',
                ['payout' => ['Payout failed']],
                422
            );
        }

        $debit = new Wallet;
        $debit->type      = 'debit';
        $debit->user_id   = $user->id;
        $debit->reward_id = $scheme->id;
        $debit->points    = $points;
        $debit->amount    = $amount;
        $debit->brand     = $brand;
        $debit->data      = json_encode($request->only(['scheme_id', 'points', 'upi_id', 'brand']));
        $debit->response  = json_encode(isset($payout['body']) ? $payout['body'] : []);
        $debit->status    = 'Success';
        $debit->save();

        return $this->ok('Payout of ' . $amount . ' initiated successfully.', [
            'amount'  => (float) $amount,
            'points'  => $points,
            'balance' => (float) $this->schemePoints($user->id, $scheme->id),
        ]);
    }

    public function placeOrder(Request $request)
    {
        $user = $this->requireUser($request);

        $this->validateInput($request, [
            'scheme_id' => 'required|integer',
            'points'    => 'required|numeric|min:1',
            'name'      => 'required|string|max:120',
            'address'   => 'required|string|max:255',
            'city'      => 'required|string|max:100',
            'state'     => 'required|string|max:100',
            'pin_code'  => 'required|numeric',
            'brand'     => 'nullable|string|max:150',
        ]);

        $brand  = $request->input('brand');
        $points = (float) $request->input('points');

        $scheme = RewardScheme::where('id', $request->input('scheme_id'))->where('status', 'Active')->first();

        if (!$scheme) {
            return $this->fail('This scheme is no longer available.', ['scheme_id' => ['Scheme inactive']], 422);
        }

        // Points only spend inside the scheme that granted them.
        $balance = $this->schemePoints($user->id, $scheme->id);

        if ($balance < $points) {
            return $this->fail(
                'You need ' . round($points - $balance, 2) . ' more points in this reward to claim that.',
                ['points' => ['Insufficient balance']],
                422
            );
        }

        $product = $this->itemValue($scheme, $points, 'product');

        if ($product === null) {
            return $this->fail('No reward is configured for these points.', ['points' => ['Invalid slab']], 422);
        }

        $history = [[
            'message' => 'Order has been placed',
            'date'    => date('M d, Y - h:i a'),
        ]];

        $order = new RewardOrder;
        $order->customer_id     = $user->id;
        $order->reward_id       = $scheme->id;
        $order->phone           = $user->phone;
        $order->name            = $request->input('name');
        $order->product         = $product;
        $order->address         = $request->input('address');
        $order->city            = $request->input('city');
        $order->state           = $request->input('state');
        $order->pin_code        = $request->input('pin_code');
        $order->points          = $points;
        $order->dispatch_status = 'Pending';
        $order->history         = json_encode($history);
        $order->save();

        $debit = new Wallet;
        $debit->type      = 'debit';
        $debit->user_id   = $user->id;
        $debit->reward_id = $scheme->id;
        $debit->points    = $points;
        $debit->brand     = $brand;
        $debit->data      = json_encode(array_merge($request->except('token'), ['product' => $product]));
        $debit->status    = 'Success';
        $debit->save();

        return $this->ok('Order placed successfully. We will keep you posted on the delivery.', [
            'order' => [
                'id'        => $order->id,
                'reference' => 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
                'product'   => $order->product,
                'points'    => (float) $order->points,
                'status'    => $order->dispatch_status,
            ],
            'balance' => (float) $this->schemePoints($user->id, $scheme->id),
        ]);
    }

    public function orders(Request $request)
    {
        $user = $this->requireUser($request);

        $query = RewardOrder::where('customer_id', $user->id)->orderBy('created_at', 'DESC');

        if ($request->filled('status')) {
            $query->where('dispatch_status', $request->input('status'));
        }

        $self = $this;

        list($items, $meta) = $this->paginate($query, $request, function ($order) use ($self) {
            return $self->orderRow($order);
        });

        return $this->ok('Orders fetched successfully', [
            'orders' => $items,
        ], ['meta' => $meta]);
    }

    public function ledgerRow($entry)
    {
        $scheme = $entry->reward_id ? RewardScheme::find($entry->reward_id) : null;

        return [
            'id'         => $entry->id,
            'type'       => $entry->type,
            'direction'  => $entry->type === 'credit' ? '+' : '-',
            'points'     => (float) $entry->points,
            'amount'     => $entry->amount !== null ? (float) $entry->amount : null,
            'brand'      => $entry->brand,
            'title'      => $entry->type === 'credit'
                ? 'Points earned' . ($entry->brand ? ' from ' . $entry->brand : '')
                : 'Points redeemed',
            'scheme'     => $scheme ? $scheme->title : null,
            'status'     => $entry->status,
            'created_at' => $this->date($entry->created_at),
            'created_ago' => $this->ago($entry->created_at),
        ];
    }

    public function orderRow($order)
    {
        $timeline = [];

        foreach ((array) $this->json($order->history, []) as $log) {
            $timeline[] = [
                'message' => isset($log['message']) ? $log['message'] : '',
                'date'    => isset($log['date']) ? $log['date'] : '',
            ];
        }

        return [
            'id'        => $order->id,
            'reference' => 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
            'product'   => $order->product,
            'points'    => (float) $order->points,
            'status'    => $order->dispatch_status ? $order->dispatch_status : 'Pending',
            'address'   => trim($order->address . ', ' . $order->city . ', ' . $order->state . ' - ' . $order->pin_code, ', '),
            'placed_on' => $this->date($order->created_at),
            'timeline'  => $timeline,
        ];
    }

    protected function recentLedger($user_id, $limit)
    {
        $entries = Wallet::where('user_id', $user_id)
            ->where('status', 'Success')
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get();

        $rows = [];

        foreach ($entries as $entry) {
            $rows[] = $this->ledgerRow($entry);
        }

        return $rows;
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

    protected function itemValue($scheme, $points, $type)
    {
        foreach ((array) $this->json($scheme->items, []) as $item) {
            if (isset($item['points'], $item['type']) && (float) $item['points'] === (float) $points && $item['type'] === $type) {
                return $item['item'];
            }
        }

        return null;
    }

    protected function itemLabel($item)
    {
        $type = isset($item['type']) ? $item['type'] : 'product';
        $value = isset($item['item']) ? $item['item'] : '';

        if ($type === 'amount') {
            return 'Cash payout of ' . $value;
        }

        return $value;
    }

    protected function schemeBrand($scheme)
    {
        if (!$scheme->user_id) {
            return null;
        }

        $owner = User::find($scheme->user_id);

        return $owner ? $owner->brand : null;
    }

    /**
     * Everything the shopper has put in motion to claim a reward — gift
     * orders and cash payouts in one list, newest first, each with the stage
     * it has reached.
     */
    public function transactions(Request $request)
    {
        $user = $this->requireUser($request);

        $rows = [];

        $orders = RewardOrder::where('customer_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->limit(60)
            ->get();

        foreach ($orders as $order) {
            $status = $order->dispatch_status ? $order->dispatch_status : 'Pending';
            $scheme = $order->reward_id ? RewardScheme::find($order->reward_id) : null;

            $timeline = [];

            foreach ((array) $this->json($order->history, []) as $log) {
                $timeline[] = [
                    'message' => isset($log['message']) ? $log['message'] : '',
                    'date'    => isset($log['date']) ? $log['date'] : '',
                ];
            }

            $rows[] = [
                'id'         => 'order-' . $order->id,
                'kind'       => 'gift',
                'reference'  => 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
                'title'      => $order->product ?: 'Reward item',
                'scheme'     => $scheme ? $scheme->title : null,
                'points'     => (float) $order->points,
                'amount'     => null,
                'status'     => $status,
                'stage'      => $this->orderStage($status),
                'is_open'    => strtolower($status) !== 'delivered'
                    && strtolower($status) !== 'cancelled',
                'address'    => trim(
                    $order->address . ', ' . $order->city . ', ' . $order->state . ' - ' . $order->pin_code,
                    ', '
                ),
                'timeline'   => $timeline,
                'created_at' => $this->date($order->created_at),
                'created_ago' => $this->ago($order->created_at),
                'sort'       => strtotime($order->created_at),
            ];
        }

        $payouts = Wallet::where('user_id', $user->id)
            ->where('type', 'debit')
            ->whereNotNull('amount')
            ->where('amount', '>', 0)
            ->orderBy('created_at', 'DESC')
            ->limit(60)
            ->get();

        foreach ($payouts as $payout) {
            $status = $payout->status ? $payout->status : 'Pending';
            $scheme = $payout->reward_id ? RewardScheme::find($payout->reward_id) : null;

            $rows[] = [
                'id'         => 'cash-' . $payout->id,
                'kind'       => 'cash',
                'reference'  => 'PAY-' . str_pad($payout->id, 6, '0', STR_PAD_LEFT),
                'title'      => 'Cash to UPI',
                'scheme'     => $scheme ? $scheme->title : null,
                'points'     => (float) $payout->points,
                'amount'     => (float) $payout->amount,
                'status'     => $status,
                'stage'      => strtolower($status) === 'success' ? 3 : 1,
                'is_open'    => strtolower($status) !== 'success'
                    && strtolower($status) !== 'failed',
                'address'    => null,
                'timeline'   => [],
                'created_at' => $this->date($payout->created_at),
                'created_ago' => $this->ago($payout->created_at),
                'sort'       => strtotime($payout->created_at),
            ];
        }

        usort($rows, function ($a, $b) {
            return $b['sort'] - $a['sort'];
        });

        $open = 0;

        foreach ($rows as $row) {
            if ($row['is_open']) {
                $open++;
            }
        }

        return $this->ok('Transactions fetched successfully', [
            'transactions' => $rows,
            'open_count'   => $open,
            'stages'       => ['Placed', 'Packed', 'On the way', 'Delivered'],
        ]);
    }

    protected function orderStage($status)
    {
        switch (strtolower($status)) {
            case 'delivered':
                return 3;
            case 'shipped':
            case 'dispatched':
            case 'on the way':
                return 2;
            case 'packed':
            case 'processing':
                return 1;
            default:
                return 0;
        }
    }

}
