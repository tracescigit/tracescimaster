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
    public function summary(Request $request)
    {
        $user = $this->requireUser($request);

        $earned = Wallet::where('user_id', $user->id)
            ->where('type', 'credit')
            ->where('status', 'Success')
            ->sum('points');

        $spent = Wallet::where('user_id', $user->id)
            ->where('type', 'debit')
            ->where('status', 'Success')
            ->sum('points');

        $cashOut = Wallet::where('user_id', $user->id)
            ->where('type', 'debit')
            ->where('status', 'Success')
            ->sum('amount');

        return $this->ok('Rewards summary fetched successfully', [
            'balance'          => (float) getWalletBalance($user->id),
            'lifetime_earned'  => (float) $earned,
            'lifetime_spent'   => (float) $spent,
            'cash_redeemed'    => (float) $cashOut,
            'brands'           => $this->brandBalances($user->id),
            'pending_orders'   => RewardOrder::where('customer_id', $user->id)
                ->where('dispatch_status', '!=', 'Delivered')
                ->count(),
            'recent'           => $this->recentLedger($user->id, 5),
        ]);
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
            $balance = (float) getWalletBalance($user->id, $brand);

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
            'balance'      => (float) getWalletBalance($user->id, $brand),
            'total_balance' => (float) getWalletBalance($user->id),
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

        $brand   = $request->input('brand');
        $points  = (float) $request->input('points');
        $balance = (float) getWalletBalance($user->id, $brand);

        if ($balance < $points) {
            return $this->fail(
                'You need ' . round($points - $balance, 2) . ' more points to redeem this.',
                ['points' => ['Insufficient balance']],
                422
            );
        }

        $scheme = RewardScheme::where('id', $request->input('scheme_id'))->where('status', 'Active')->first();

        if (!$scheme) {
            return $this->fail('This scheme is no longer available.', ['scheme_id' => ['Scheme inactive']], 422);
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
            'balance' => (float) getWalletBalance($user->id, $brand),
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

        $brand   = $request->input('brand');
        $points  = (float) $request->input('points');
        $balance = (float) getWalletBalance($user->id, $brand);

        if ($balance < $points) {
            return $this->fail(
                'You need ' . round($points - $balance, 2) . ' more points to redeem this.',
                ['points' => ['Insufficient balance']],
                422
            );
        }

        $scheme = RewardScheme::where('id', $request->input('scheme_id'))->where('status', 'Active')->first();

        if (!$scheme) {
            return $this->fail('This scheme is no longer available.', ['scheme_id' => ['Scheme inactive']], 422);
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
            'balance' => (float) getWalletBalance($user->id, $brand),
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
}
