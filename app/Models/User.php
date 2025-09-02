<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that appends to returned entities.
     *
     * @var array
     */
    protected $appends = ['photo'];

    /**
     * The getter that return accessible URL for user photo.
     *
     * @var array
     */
    public function getPhotoAttribute()
    {
        if ($this->foto !== null) {
            return url('media/user/' . $this->id . '/' . $this->foto);
        } else {
            return url('media-example/no-image.png');
        }
    }

    public static function getManufacturerModel($limit, $page, $orderby, $order , $search_field , $search_type, $search_value,$start_date=null,$end_date=null)
    {
        $q = User::select('users.*')->where('type','2')->where('parent_id',null);

        if($start_date!=null){
            $q->whereDate('created_at','>=',$start_date);
        }

        if($end_date!=null){
            $q->whereDate('created_at','<=',$end_date);
        }

        $orderby  = $orderby ? $orderby : 'created_at';
        $order    = $order ? $order : 'desc';

        if($search_value && !empty($search_value) && !empty($search_field))
        {   
            $search_value = strtolower($search_value);
            if($search_value== 'inactive' || $search_value== 'no')
            {
                $search_value = '0';
            }
            if($search_value== 'active' || $search_value== 'yes')
            {
                $search_value = '1';
            }
            if($search_field == 'name')
            {
                $q->where(function($query) use ($search_field , $search_type, $search_value) {
                    $query->where('name','LIKE',"%".$search_value."%");
                }); 
            }
            else{
                $q->where(function($query) use ($search_field , $search_type, $search_value) {
                    $query->where($search_field, $search_type, ($search_type=='like'?('%'.$search_value.'%'):$search_value));
                });
            }
        }

        $total = $q->count();

        $response =  $q->orderBy($orderby, $order)->paginate($limit, ['*'], 'page', $page);

        return ['response' => $response,'last_page' => $response->lastPage(),'total'=>$total];
    }

    public static function getVendorUserModel($limit, $page, $orderby, $order , $search_field , $search_type, $search_value,$start_date=null,$end_date=null)
    {
        $q = User::select('users.*')->where('users.type','!=','5')->where('users.id' , '<>', Auth::user()->id)->where('parent_id',Auth::user()->parent_id??Auth::user()->id);

        if($start_date!=null){
            $q->whereDate('created_at','>=',$start_date);
        }

        if($end_date!=null){
            $q->whereDate('created_at','<=',$end_date);
        }

        $orderby  = $orderby ? $orderby : 'created_at';
        $order    = $order ? $order : 'desc';

        if($search_value && !empty($search_value))
        {   
            $search_value = strtolower($search_value);

            if($search_value== 'inactive')
            {
                $search_value = '0';
            }
            if($search_value== 'active' )
            {
                $search_value = '1';
            }

            $q->where(function($query) use ($search_field , $search_type, $search_value) {
                $query->where($search_field, $search_type, ($search_type=='like'?('%'.$search_value.'%'):$search_value));
            });
        }

        $total = $q->count();

        $response =  $q->orderBy($orderby, $order)->paginate($limit, ['*'], 'page', $page);

        return ['response' => $response,'last_page' => $response->lastPage(),'total'=>$total];
    }

    public static function getAdminUserModel($limit, $page, $orderby, $order , $search_field , $search_type, $search_value,$start_date=null,$end_date=null)
    {
        $q = User::select('users.*')->where('users.id' , '<>', Auth::user()->id)->where('parent_id',Auth::user()->parent_id??Auth::user()->id);

        if($start_date!=null){
            $q->whereDate('created_at','>=',$start_date);
        }

        if($end_date!=null){
            $q->whereDate('created_at','<=',$end_date);
        }

        $orderby  = $orderby ? $orderby : 'created_at';
        $order    = $order ? $order : 'desc';

        if($search_value && !empty($search_value))
        {   
            $search_value = strtolower($search_value);

            if($search_value== 'inactive')
            {
                $search_value = '0';
            }
            if($search_value== 'active' )
            {
                $search_value = '1';
            }
            
            $q->where(function($query) use ($search_field , $search_type, $search_value) {
                $query->where($search_field, $search_type, ($search_type=='like'?('%'.$search_value.'%'):$search_value));
            });
        }

        
        $total = $q->count();

        $response =  $q->orderBy($orderby, $order)->paginate($limit, ['*'], 'page', $page);

        return ['response' => $response,'last_page' => $response->lastPage(),'total'=>$total];
    }

    public function getCompany()
    {
        return $this->belongsTo(Company::class,'id','user_id');
    }

    public function getSubscription()
    {
        return $this->belongsTo(Subscription::class,'id','user_id')->where('type','0');
    }

    public function getAllDocs()
    {
        return $this->hasMany(Document::class,'user_id','id');
    }

}
