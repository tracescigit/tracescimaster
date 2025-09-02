<?php

namespace App\Models;

use App\Models\SmsTemplate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasFactory;

    public static function sendSms($slug,$input){

        $template = SmsTemplate::where('slug',$slug)->first();

        $sms_body           = $template->email_body;
        $sms_id             = $template->dltteid;
        $dynamic_values     = $template->text_tag;
        $dynamic_values     = array_map('trim', explode(',', $template->text_tag));

        foreach ($dynamic_values as $values){
            $sms_body       = str_replace( '{{'.$values.'}}', $input[$values], $sms_body );
        }

        $sendsms = sendSMS($input['code'],$input['phone'],$sms_id,$sms_body);

        return $sendsms;
    }
}
