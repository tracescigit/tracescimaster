<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserCreateRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\Company;
use App\Models\Document;
use App\Models\Module;
use App\Models\Notification;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Sms;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use EmailProvider;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

            $response       = User::getAdminUserModel($limit, $page, $orderby, $order, $search_field , $search_type, $search_value,$start_date,$end_date);

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

                $actions            = view('admin.users.actions',['id' => $user->id]);
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
        return view('admin.users.index');
    }

    public function create()
    {   
        $roles = Role::where('type',Auth::user()->type)->get();
        $modules = Module::where('type',Auth::user()->type)->get();
        return view('admin.users.create')->with('roles',$roles)->with('modules',$modules);
    }

    public function store(UserCreateRequest $request)
    {
        try{
            $input = $request->all();

            // dd($input);
            $password = Str::random(8);

            $user = new User;
            $user->username = $input['email'];
            $user->email    = $input['email'];
            $user->type     = Auth::user()->type;
            $user->name     = $input['full_name'];
            $user->phone_code   = $input['phone_code']??'91';
            $user->phone    = $input['mobile'];
            $user->status   = $input['allow_login'];
            $user->active   = '1';
            $user->parent_id = Auth::user()->parent_id??Auth::id();
            $user->password     = bcrypt($password);
            $user->who_you_are  = $input['role'];
            $user->created_at = Carbon::now();
            $user->updated_at = Carbon::now();

            if(isset($input['province']) && $input['province']!=''){
                $user->business_location = json_encode($input['province']);
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

            Sms::sendSms('TRCLogin', 
                [   
                    'username' => $user->name??'User',
                    'phone' => $user->phone,
                    'code' => $user->phone_code??'91',
                    'email' => $user->email,
                    'password' => $password
                ]
            );

            EmailProvider::sendMail('user-credential-email',
                [   
                    'username' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'password' => $password
                ]
            );

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
        $modules = Module::where('type',Auth::user()->type)->get();
        return view('admin.users.edit')->with('user',$user)->with('page_name', 'admin-users')->with('roles',$roles)->with('modules',$modules);
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
                $user->name     = $input['full_name'];
                $user->phone_code  = $input['phone_code']??'91';
                $user->phone  = $input['mobile'];
                $user->status  = $input['allow_login'];

                if(isset($input['login_password']) && $input['login_password']!=''){
                    $user->password = bcrypt($input['login_password']); 
                }

                if(isset($input['province']) && $input['province']!=''){
                    $user->business_location = json_encode($input['province']);
                }
                
                $user->who_you_are  = $input['role'];
                $user->updated_at = Carbon::now();
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
