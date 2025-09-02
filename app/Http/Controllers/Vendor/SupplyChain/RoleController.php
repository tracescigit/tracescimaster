<?php

namespace App\Http\Controllers\Vendor\SupplyChain;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\SupplyChainRoleCreateRequest;
use App\Http\Requests\Vendor\SupplyChainRoleUpdateRequest;
use App\Models\SupplyChainRole;
use App\Models\SupplyChainUser;
use Auth;
use Illuminate\Http\Request;

class RoleController extends Controller
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

            $response       = SupplyChainRole::getSupplyChainRoleModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value, Auth::user()->parent_id??Auth::id());

            if(!$response){
                $supply_chain_roles      = [];
                $last_page  = 0;
                $total = 0;
            }
            else{
                $supply_chain_roles      = $response['response'];
                $last_page     = $response['last_page'];
                $total     = $response['total'];
            }

            $supply_chain_roleData = array();
            $i = 1;

            foreach ($supply_chain_roles as $supply_chain_role) {

                $u['name']          = $supply_chain_role->name??'-';
                $u['created_at']    = date('M d, Y',strtotime($supply_chain_role->created_at))??'-';
                $actions            = view('vendor.supply_chain_roles.actions',['id' => $supply_chain_role->id]);
                $u['actions']       = $actions->render(); 
                $supply_chain_roleData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $supply_chain_roleData,
                "total"             =>  $total
            ];
            
            return $return;
        }
        return view('vendor.supply_chain_roles.index');
    }

    public function create()
    {
        return view('vendor.supply_chain_roles.create'); 
    }

    public function store(SupplyChainRoleCreateRequest $request)
    {
        try{
            $input   = $request->all();
            $supply_chain_role = new SupplyChainRole;

            $supply_chain_role->name = $input['name'];
            $supply_chain_role->user_id = Auth::user()->parent_id??Auth::id();

            $supply_chain_role->save();

            return response(['message'=>'Supply Chain Role created successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function edit($id)
    {   
        $id = decrypt($id);

        $role = SupplyChainRole::find($id);
        return view('vendor.supply_chain_roles.edit')->with('role',$role)->with('page_name', 'vendor-supply-chain-roles');
    }

    public function update(SupplyChainRoleUpdateRequest $request ,$id)
    {
        try{
            $id = decrypt($id);

            $input   = $request->all();
            $supply_chain_role = SupplyChainRole::find($id);
            $old_name = $supply_chain_role->name;
            $supply_chain_role->name = $input['name'];
            $supply_chain_role->save();

            $update_users = SupplyChainUser::where('type','5')->where('parent_id',Auth::user()->parent_id??Auth::id())->where('who_you_are',$old_name)->update(['who_you_are'=>$supply_chain_role->name]);

            return response(['message'=>'Supply Chain Role updated successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function destroy($id)
    {
        try{
            $id = decrypt($id);
            $supply_chain_role = SupplyChainRole::find($id);
            $supply_chain_role->delete();
            return response(['message'=>'Supply Chain Role deleted successfully.'], 200);
        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }
}
