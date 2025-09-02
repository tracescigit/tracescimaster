<?php

namespace App\Exports;

use App\Models\Code;
use Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class CodeExport implements FromView
{
	public function view(): View
	{
		return view('exports.codes', [
			'codes' => Code::where('user_id',Auth::id())->where('exported','0')->get()
		]);
	}
}
