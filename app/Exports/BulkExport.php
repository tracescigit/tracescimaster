<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromView;

class BulkExport implements FromView
{	
	public function  __construct($codes)
	{
		$this->codes = $codes;
	}

	public function view(): View
	{
		Log::info(['codes'=>$this->codes]);
		return view('exports.codes', ['codes' => $this->codes]);
	}
}
