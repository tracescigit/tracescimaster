<?php

namespace App\Http\Controllers;

use App\Models\Code;
use Illuminate\Http\Request;

class ScanController extends Controller
{
	public function show(Request $request, $code)
	{
		$qr = Code::where('qr_code', $code)->first();
		$product = $qr->getProduct;

		$auth_required = true;
		if ($qr->getProduct->pin_required == 1) {
			$secret_code_check_required = true;
		} else {
			$secret_code_check_required = false;
		}

		if ($product && $product->auth_required == false) {
			$auth_required = false;
		}

		$brand = $qr->getProduct->brand ?? 'TRACESCI';
		$brand_logo = $qr->getProduct->logo ?? '';


		return view('web.scan.index')->with('code', $code)->with('auth_required', $auth_required)->with('brand', $brand)->with('brand_logo', $brand_logo)->with('secret_code_check_required', $secret_code_check_required);
	}
}
