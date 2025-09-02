<?php

namespace App\Http\Controllers\Vendor\SupplyChain;

use App\Http\Controllers\Controller;
use App\Models\SupplyChain;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    public function index(Request $request)
    {
        $users = SupplyChain::leftJoin('users','users.id','supply_chains.user_id')->where('supply_chains.supply_chain_parent_id',NULL)->where('users.parent_id',Auth::user()->parent_id??Auth::id())->orderby('supply_chains.created_at','DESC')->get();
        return view('vendor.supply_chains.index')->with('users',$users);
    }

    public function users(Request $request, $role)
    {
        $input = $request->all();

        $users_q = SupplyChain::leftJoin('users','users.id','supply_chains.user_id')->where('users.parent_id',Auth::user()->parent_id??Auth::id());

        $parent = null;

        if (isset($input['parent']) && $input['parent']!='') {
            $parent = User::find($input['parent']);
            $users_q->where('supply_chains.supply_chain_parent_id',$input['parent']);
        }

        $supply_chain_users = $users_q->pluck('users.id');

        if ($role=='none') {
            $q = User::whereNotIn('id',$supply_chain_users)->where('type','5')->where('parent_id',Auth::user()->parent_id??Auth::id())->orderby('who_you_are','ASC');
        }else{
            $q = User::whereNotIn('id',$supply_chain_users)->where('type','5')->where('who_you_are',$role)->where('parent_id',Auth::user()->parent_id??Auth::id())->orderby('who_you_are','ASC');
        }

        if ($parent) {
            $q->where('users.who_you_are','!=',$parent->who_you_are);
        }

        $users = $q->where('users.supply_parent_id',null)->get();
        $view = view('vendor.supply_chains.users')->with('users',$users);

        return $view->render();
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $supply_chain = new SupplyChain;
        $supply_chain->user_id = $input['user'];

        if (isset($input['parent_id']) && $input['parent_id']!='') {
            $supply_chain->supply_chain_parent_id = $input['parent_id'];
        }

        $supply_chain->save();

        return response(['message'=>'Action success.'], 201);
    }

    public function show($id)
    {
        $id= decrypt($id);
        $supply = SupplyChain::where('user_id',$id)->first();
        $view = view('vendor.supply_chains.view',['supply'=>$supply]);
        return $view->render();
    }

    public function userData($id)
    {
        $id= decrypt($id);
        $user = User::where('id',$id)->first();
        $view = view('vendor.supply_chains.user',['user'=>$user]);
        return $view->render();
    }

    public function destroy($id)
    {
        $id = decrypt($id);
        $users = $this->getUserData($id);

        foreach ($users as $user_id) {
            $delete = SupplyChain::where('user_id',$user_id)->delete();
        }

        return response([
            'message' => 'User deleted from supply chain'
        ],200);

    }

    public function getUserData($chain_user_id){
        $chains  = [];
        $chain = SupplyChain::where('user_id',$chain_user_id)->first();
        
        if ($chain) {
            $chains = $this->getChildren($chain->user_id,$chains);
        }

        return $chains;
    }

    public function getChildren($chain_user_id,$chains)
    {
        $chain = SupplyChain::where('user_id',$chain_user_id)->first();

        if ($chain) {
            array_push($chains,$chain->user_id);
        }

        if($chain->getChildren && count($chain->getChildren)>0){
            foreach ($chain->getChildren as $child) {
                $chains = $this->getChildren($child->user_id,$chains);
            }
        }

        return $chains;
    }
}
