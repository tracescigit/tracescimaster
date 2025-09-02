<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
class EmailController extends Controller
{
	public function index(Request $request)
	{	
		if($request->ajax())
		{	
			$limit          = $request->input('size');
			$page           = $request->input('page');
			$search_field   = $request['filters']?$request['filters']['0']['field']:'';
			$search_type    = $request['filters']?$request['filters']['0']['type']:'';
			$search_value   = $request['filters']?$request['filters']['0']['value']:'';
			$orderby        = $request['sorters']?$request['sorters']['0']['field']:'';			
			$order          = $orderby != "" ? $request['sorters']['0']['dir'] : "";

			$response       = EmailTemplate::getEmailTemplate($limit, $page, $orderby, $order, $search_field , $search_type, $search_value);

			if(!$response){
				$emails      = [];
				$last_page  = 0;
			}
			else{
				$emails      = $response['response'];
				$last_page     = $response['last_page'];
			}

			$emailData = array();
			$i = 1;

			foreach ($emails as $email) {

				$u['slug']          = $email->slug??'-';
				$u['subject']       = $email->subject??'-';
				$u['created_at']    =  date('M d, Y' ,  strtotime($email->created_at))??'-';

				// $actions            = view('admin.emails.actions',['id' => $email->id]);
				// $u['actions']       = $actions->render(); 

				$emailData[] = $u;
				$i++;
				unset($u);
			}

			$return = [
				"last_page"		    =>  $last_page,
				"data"              =>  $emailData
			];
			
			return $return;
		}
		return view('admin.emails.index');
	}
}
