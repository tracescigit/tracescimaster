<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Damage;
class DamageController extends Controller
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

            $response  = Damage::getDamages($limit, $page, $orderby, $order, $search_field , $search_type, $search_value);

            if(!$response){
                $damages      = [];
                $last_page  = 0;
                $total = 0;
            }
            else{
                $damages      = $response['response'];
                $last_page     = $response['last_page'];
                $total     = $response['total'];
            }

            $damageData = array();
            $i = 1;

            foreach ($damages as $damage) {

                $u['lot_id']        = $damage->lot_id??'-';
                $u['total_stamps']  = $damage->total_stamps??'-';
                $u['manufacturer_name']=$damage->getUser->getCompany->name;
                $u['reason']        = $damage->reason??'-';
                $u['created_at']    = date('M d, Y',strtotime($damage->created_at))??'-';
                $actions            = view('admin.damages.actions',['id' => $damage->id]);
                $u['actions']       = $actions->render(); 

                $damageData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $damageData,
                "total"              =>  $total
            ];

            return $return;
        }
        return view('admin.damages.index');
    }

    public function show($id)
    {   
        $id    = decrypt($id);
        $damage = Damage::find($id);
        
        return view('admin.damages.details')->with('damage',$damage)->with('page_name','admin-lost-damage');
    }

}
