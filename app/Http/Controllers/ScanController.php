<?php

namespace App\Http\Controllers;

use App\Models\Code;
use Illuminate\Http\Request;

class ScanController extends Controller
{
	public function show(Request $request, $code)
	{
		$qr = Code::where('qr_code',$code)->first();
		$product = $qr->getProduct;

		$auth_required = true;

		if ($product && $product->auth_required==false) {
			$auth_required = false;
		}

		$brand = $qr->getProduct->brand??'TRACESCI';

		return view('web.scan.index')->with('code',$code)->with('auth_required',$auth_required)->with('brand',$brand);
	}
}
