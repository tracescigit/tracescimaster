<?php

namespace App\Exports\Vendor;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CouponCodeExport implements FromView
{
    public function  __construct($coupon_codes)
    {
        $this->coupon_codes = $coupon_codes;
    }

    public function view(): View
    {
        return view('exports.coupon_codes', ['coupon_codes' => $this->coupon_codes]);
    }
}
