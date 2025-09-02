<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BulkExport implements FromView
{	
	public function  __construct($codes)
	{
		$this->codes = $codes;
	}

	public function view(): View
	{
		return view('exports.codes', ['codes' => $this->codes]);
	}
}
