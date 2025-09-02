<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrintingCost;
use Illuminate\Http\Request;

class PrintingCostController extends Controller
{
    public function index()
    {
        $cost = PrintingCost::first();
        return view('admin.printing_costs.create')->with('cost',$cost);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $cost = PrintingCost::first();

        if (!$cost) {
            $cost = new PrintingCost;
        }

        $cost->black_and_white = $input['black_and_white'];
        $cost->black_and_white_price_usd = $input['black_and_white_price_usd'];
        $cost->color = $input['color'];
        $cost->color_price_usd = $input['color_price_usd'];
        $cost->save();

        return response([
            'success'=>true,
            'message'=>'Costs updated successfully.'
        ],201);
    }
}
