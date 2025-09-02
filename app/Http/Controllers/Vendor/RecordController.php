<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\UploadProgress;

class RecordController extends Controller
{
    public function credits()
    {
        $results = [
            'credit'     => getUsedCredits(Auth::id()).' / '.getCreditAmount(Auth::id()),
            'inprogress' => '',
            'notify'     => ''
        ];

        $upload_progress = UploadProgress::where('user_id',Auth::user()->parent_id??Auth::id())->where('status','1')->get();
        $view_progress   = view('vendor.progresses.upload')->with('upload_progress',$upload_progress);

        $results['inprogress'] = $view_progress->render();
        $notify = UploadProgress::where('user_id',Auth::user()->parent_id??Auth::id())->where('status','2')->where('notified','0')->first();
        
        if ($notify) {
            $view_notify   = view('vendor.progresses.notify')->with('notify',$notify);
            $results['notify'] = $view_notify->render();
            $notify->notified = '1';
            $notify->save();
        }        

        return $results;
    }
}
