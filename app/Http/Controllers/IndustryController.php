<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndustryController extends Controller
{
    public function industry()
    {
        return view('web.industry.index');
    }
}
