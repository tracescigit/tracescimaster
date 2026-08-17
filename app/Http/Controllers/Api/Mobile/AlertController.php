<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Api\ApiController;
use App\Models\Alert;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AlertController extends ApiController
{
    public function feed(Request $request)
    {
        $user  = $this->requireUser($request);
        $owner = $this->ownerId($user);
        $role  = $this->role($user);

        $isBrandSide = in_array($role, [
            self::ROLE_BRAND,
            self::ROLE_ADMIN,
            self::ROLE_AUTHORITY,
            self::ROLE_INSPECTOR,
        ], true);

        $productIds = $isBrandSide
            ? Product::where('user_id', $owner)->pluck('id')
            : collect();

        $query = Alert::where(function ($q) use ($user, $isBrandSide, $productIds, $owner) {
            $q->where('scanned_by', $user->id);

            if ($isBrandSide) {
                $q->orWhereIn('product_id', $productIds)
                  ->orWhere('manufacturer_assigned_to', $owner)
                  ->orWhere('vendor_assigned_to', $owner)
                  ->orWhere('admin_assigned_to', $user->id);
            }
        })->orderBy('created_at', 'DESC');

        if ($request->filled('scope')) {
            if ($request->input('scope') === 'mine') {
                $query = Alert::where('scanned_by', $user->id)
                    ->orderBy('created_at', 'DESC');
            } elseif ($request->input('scope') === 'products' && $isBrandSide) {
                $query = Alert::whereIn('product_id', $productIds)
                    ->orderBy('created_at', 'DESC');
            }
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $self = $this;
        $me   = $user;

        list($items, $meta) = $this->paginate($query, $request, function ($alert) use ($self, $me) {
            return $self->row($alert, $me);
        });

        $mineCount = Alert::where('scanned_by', $user->id)->count();

        $productCount = $isBrandSide
            ? Alert::whereIn('product_id', $productIds)->count()
            : 0;

        return $this->ok('Alerts fetched successfully', [
            'alerts'        => $items,
            'can_see_products' => $isBrandSide,
            'counts'        => [
                'mine'     => $mineCount,
                'products' => $productCount,
            ],
        ], ['meta' => $meta]);
    }

    public function row($alert, $me)
    {
        $isReport  = (string) $alert->type === '1';
        $raisedByMe = (string) $alert->scanned_by === (string) $me->id;
        $scanner   = $alert->scanned_by ? User::find($alert->scanned_by) : null;

        return [
            'id'           => $alert->id,
            'reference'    => ($isReport ? 'RPT-' : 'ALT-') . str_pad($alert->id, 6, '0', STR_PAD_LEFT),
            'kind'         => $isReport ? 'Report' : 'Automatic alert',
            'title'        => $this->friendlyTitle($alert),
            'product_name' => $alert->product_name,
            'batch'        => $alert->batch,
            'issue_type'   => $alert->issue_type,
            'description'  => $alert->alert_message,
            'status'       => (string) $alert->status === '1' ? 'Resolved' : 'Open',
            'is_open'      => (string) $alert->status !== '1',
            'raised_by_me' => $raisedByMe,
            'raised_by'    => $raisedByMe
                ? 'You'
                : ($scanner ? ($scanner->name ?: trim($scanner->phone_code . ' ' . $scanner->phone)) : 'Unknown'),
            'image'        => $this->assetUrl($alert->image),
            'location'     => $this->json($alert->location, null),
            'resolution'   => (string) $alert->status === '1'
                ? ($alert->manufacturer_comment ?: $alert->admin_comment)
                : null,
            'created_at'   => $this->date($alert->created_at),
            'created_ago'  => $this->ago($alert->created_at),
        ];
    }

    protected function friendlyTitle($alert)
    {
        $message = strtolower((string) $alert->alert_message);

        if (str_contains($message, 'fake')) {
            return 'Possible fake pack';
        }

        if (str_contains($message, 'deactivated')) {
            return 'Deactivated pack scanned';
        }

        if (str_contains($message, 'expired')) {
            return 'Expired pack scanned';
        }

        if (str_contains($message, 'different ip')) {
            return 'Same pack scanned from another place';
        }

        if (str_contains($message, 'wrong location')) {
            return 'Pack scanned at an unexpected place';
        }

        if (str_contains($message, 'banned')) {
            return 'Pack from a blocked maker';
        }

        if (str_contains($message, 'mismatch')) {
            return 'Pack details do not match';
        }

        return (string) $alert->type === '1' ? 'You reported a problem' : 'Something looked wrong';
    }
}
