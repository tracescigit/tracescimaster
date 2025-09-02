<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\UserCreateRequest;
use App\Http\Requests\Vendor\UserUpdateRequest;
use App\Models\Module;
use App\Models\Permission;
use App\Models\Product;
use App\Models\Role;
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

            $response       = User::getVendorUserModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value,$start_date,$end_date);

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
                $u['first_name']    = $user->name;
                $u['email']         = $user->email??'-';
                $u['phone']         = $user->phone??'-';
                $u['status']        = $this->status($user->status);
                $u['who_you_are']   = __($user->who_you_are)??'-';

                $actions            = view('vendor.users.actions',['id' => $user->id]);
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
        return view('vendor.users.index');
    }

    public function create()
    {   
        $brands  = Product::where('user_id',Auth::id())->distinct()->pluck('brand');
        $roles   = Role::where('type',Auth::user()->type)->get();
        $modules = Module::where('type',Auth::user()->type)->get();
        return view('vendor.users.create')->with('roles',$roles)->with('modules',$modules)->with('brands',$brands);
    }

    public function store(UserCreateRequest $request)
    {
        try{
            $input = $request->all();

            $users_count = getTotalUsers(Auth::user()->parent_id??Auth::id());
            $plan        = getSubscriptionPlan(Auth::user()->parent_id??Auth::id());
            
            if (!$plan || ($plan->users<=$users_count)) {
                return response(['message'=>'You have reached maximum user creation limit.'], 503);
            }

            $password = Str::random(8);

            $user = User::where('email',$input['email'])->orWhere('phone',$input['mobile'])->first();

            if (!$user) {
                $user = new User;
            }
            
            $user->username = $input['email'];
            $user->email = $input['email'];
            $user->type  = Auth::user()->type;
            $user->name  = $input['full_name'];
            $user->phone_code  = $input['phone_code']??'91';
            $user->phone  = $input['mobile'];
            $user->status  = $input['allow_login'];
            $user->active  = '1';
            $user->parent_id = Auth::user()->parent_id??Auth::id();
            $user->password = bcrypt($password);
            $user->who_you_are  = $input['role'];
            $user->created_at = Carbon::now();
            $user->updated_at = Carbon::now();

            if (isset($input['brand']) && $input['brand']!='') {
                $user->brand = $input['brand'];
            }

            $user->save();

            $destroy_permissions = Permission::where('user_id',$user->id)->delete();

            if (isset($input['view']) && count($input['view'])>0) {
                foreach($input['view'] as $module){
                    $assign = $this->assignPermission('view',$module,$user->id);
                }
            }

            if (isset($input['modify']) && count($input['modify'])>0) {
                foreach($input['modify'] as $module){
                    $assign = $this->assignPermission('modify',$module,$user->id);
                }
            }

            $user_data_email = [
                'email_body' => 'User creation successful for role '.$input['role'].'.<br> Please login with following credentials.<br><strong> Email:</strong> '.$input['email'].' <strong>Password:</strong> '.$password,
                'email_subject'=> 'User Created Successfully',
                'email'=> $input['email'],
            ];

            $send_email = sendEmail($user_data_email);
            
            return response(['message'=>'User created successfully.'], 201);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }

    public function assignPermission($permission,$module,$user_id){

        $assign = Permission::where('module_id',$module)->where('user_id',$user_id)->first();

        if(!$assign){
            $assign = new Permission;
        }

        $assign->user_id = $user_id;
        $assign->module_id = $module;
        $assign->$permission = '1';

        if ($permission=='modify') {
            $assign->view = '1';
        }

        $assign->save();

        return true;
    }

    public function edit($id)
    {   
        $id = decrypt($id);
        $user = User::find($id);
        $roles = Role::where('type',Auth::user()->type)->get();
        $brands  = Product::where('user_id',Auth::id())->distinct()->pluck('brand');
        $modules = Module::where('type',Auth::user()->type)->get();
        return view('vendor.users.edit')->with('user',$user)->with('page_name', 'vendor-users')->with('roles',$roles)->with('modules',$modules)->with('brands',$brands);
    }


    public function update(UserUpdateRequest $request, $id)
    {
        try{
            $id = decrypt($id);
            $input = $request->all();

            $user = User::find($id);

            if($user){

                $user->username = $input['email'];
                $user->email = $input['email'];
                $user->name  = $input['full_name'];
                $user->phone_code  = $input['phone_code']??'91';
                $user->phone  = $input['mobile'];
                $user->status  = $input['allow_login'];

                if(isset($input['login_password']) && $input['login_password']!=''){
                    $user->password = bcrypt($input['login_password']); 
                }
                
                $user->who_you_are  = $input['role'];
                $user->updated_at = Carbon::now();

                if (isset($input['brand']) && $input['brand']!='') {
                    $user->brand = $input['brand'];
                }

                $user->save();

                $destroy_permissions = Permission::where('user_id',$user->id)->delete();

                if (isset($input['view']) && count($input['view'])>0) {
                    foreach($input['view'] as $module){
                        $assign = $this->assignPermission('view',$module,$user->id);
                    }
                }

                if (isset($input['modify']) && count($input['modify'])>0) {
                    foreach($input['modify'] as $module){
                        $assign = $this->assignPermission('modify',$module,$user->id);
                    }
                }

            }
            
            return response(['message'=>'User updated successfully.'], 200);

        }catch(Exception $e){
            return response(['message'=>'Something went wrong.'], 503);
        }
    }
}
