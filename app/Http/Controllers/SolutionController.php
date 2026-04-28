<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SolutionController extends Controller
{
    public function Cloud()
    {
        return view('web.solutions.cloud');
    }
}
