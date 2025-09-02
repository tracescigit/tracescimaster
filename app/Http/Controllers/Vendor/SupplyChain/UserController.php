<?php

namespace App\Http\Controllers\Vendor\SupplyChain;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\SupplyChainUserCreateRequest;
use App\Http\Requests\Vendor\SupplyChainUserUpdateRequest;
use App\Models\SupplyChain;
use App\Models\SupplyChainRole;
use App\Models\SupplyChainUser;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Str;

class UserController extends Controller
{
    public function status($status){
        switch($status){
            case '1':
            $result = 'Active';
            break;
            case '0':
            $result = 'Inactive';
            break;
            default:
            $result = 'Pending';
        }

        return $result;
    }

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

            $start_date = $request['filters']?$request['filters']['1']['value']:'';
            $end_date = $request['filters']?$request['filters']['2']['value']:'';

            $response       = SupplyChainUser::getSupplyChainUserModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value,$start_date,$end_date);

            if(!$response){
                $users      = [];
                $last_page  = 0;
                $total = 0;
            }
            else{
                $users      = $response['response'];
                $last_page  = $response['last_page'];
                $total      = $response['total'];
            }

            $userData = array();
            $i = 1;

            foreach ($users as $user) {
                $u['name']          = $user->name;
                $u['email']         = $user->email??'-';
                $u['phone']         = $user->phone??'-';
                $u['status']        = $this->status($user->status);
                $u['who_you_are']   = __($user->who_you_are)??'-';

                $actions            = view('vendor.supply_chain_users.actions',['id' => $user->id]);
                $u['actions']       = $actions->render(); 

                $userData[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                "last_page"         =>  $last_page,
                "data"              =>  $userData,
                "total"=>$total
            ];
            
            return $return;
        }
        return view('vendor.supply_chain_users.index');
    }

    public function create()
    {   
        $roles = SupplyChainRole::where('user_id',Auth::user()->parent_id??Auth::id())->get();
        return view('vendor.supply_chain_users.create')->with('roles',$roles);
    }

    public function store(SupplyChainUserCreateRequest $request)
    {
        try{
            $input = $request->all();

            $users_count = getTotalUsers(Auth::user()->parent_id??Auth::id());
            $plan        = getSubscriptionPlan(Auth::user()->parent_id??Auth::id());
            
            if (!$plan || ($plan->users<=$users_count)) {
                return response(['message'=>'You have reached maximum user creation limit.'], 503);
            }

            $password = Str::random(8);

            $user = SupplyChainUser::where('email',$input['email'])->orWhere('phone',$input['mobile'])->first();

            if (!$user) {
                $user = new SupplyChainUser;
            }
            
            $user->username = $input['email'];
            $user->email    = $input['email'];
            $user->type     = '5';
            $user->name     = $input['full_name'];
            $user->phone_code  = $input['phone_code']??'91';
            $user->phone    = $input['mobile'];
            $user->status   = $input['user_status'];
            $user->address_one   = $input['address'];
            $user->active   = '1';
            $user->parent_id = Auth::user()->parent_id??Auth::id();
            $user->password = bcrypt($password);
            $user->who_you_are  = $input['role'];
            $user->created_at = Carbon::now();
            $user->updated_at = Carbon::now();

            if (isset($input['parent_user']) && $input['parent_user']!='') {
                $user->supply_parent_id = $input['parent_user'];
            }

            $user->save();
            
            return response(['message'=>'Supply Chain User created successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function edit($id)
    {   
        $id    = decrypt($id);
        $user  = SupplyChainUser::find($id);
        $roles = SupplyChainRole::where('user_id',Auth::user()->parent_id??Auth::id())->get();
        $supply_chain_users = User::where('parent_id',Auth::user()->parent_id??Auth::id())->where('type','5')->where('who_you_are',$user->who_you_are)->where('supply_parent_id',null)->get();
        return view('vendor.supply_chain_users.edit')->with('user',$user)->with('page_name', 'vendor-users')->with('roles',$roles)->with('supply_chain_users',$supply_chain_users);
    }


    public function update(SupplyChainUserUpdateRequest $request, $id)
    {
        try{
            $id    = decrypt($id);
            $input = $request->all();

            $user = SupplyChainUser::find($id);

            if($user){

                $user->username = $input['email'];
                $user->email    = $input['email'];
                $user->name     = $input['full_name'];
                $user->phone_code  = $input['phone_code']??'91';
                $user->phone    = $input['mobile'];
                $user->status   = $input['user_status'];  
                $user->address_one = $input['address'];
                $user->who_you_are = $input['role'];
                $user->updated_at  = Carbon::now();

                if (isset($input['parent_user']) && $input['parent_user']!='') {
                    $user->supply_parent_id = $input['parent_user'];
                }

                $user->save();
            }
            
            return response(['message'=>'Supply Chain User updated successfully.'], 200);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function usersByRole($role)
    {
        $users = User::where('parent_id',Auth::user()->parent_id??Auth::id())->where('type','5')->where('who_you_are',$role)->where('supply_parent_id',null)->get();

        $view = view('vendor.supply_chain_users.users')->with('users',$users);

        return response([
            'users' => $view->render()
        ],200);
    }

    public function destroy($id)
    {
        try{
            $id = decrypt($id);

            $user = User::find($id);

            if(SupplyChain::where('user_id',$id)->exists()){
                return response(['message'=>'User is added in supply chain. Please remove user from chain first.'], 400);
            }

            $user->forceDelete();

            return response(['message'=>'User deleted successfully.'], 200);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }
}
