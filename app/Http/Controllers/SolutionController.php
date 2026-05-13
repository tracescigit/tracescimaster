<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SolutionController extends Controller
{
    public function Cloud()
    {
        $country = 'India';
        return view('web.solutions.cloud')->with('country',$country);
    }
    public function enterprise()
    {
        return view('web.solutions.enterprise');
    }
}
