<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CronController extends Controller
{
    //

    public function generateInvoices()
    {
        $users = User::where('type','2')->where('parent_id',null)->get();

        foreach($users as $user) {
            updateInvoices($user->id);

        }
        return true;
    }
}
