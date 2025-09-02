<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSmsTemplatesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('sms_templates')->insert(
            array(
                'slug'          => 'TRCDecined',
                'subject'       => 'TRCDecined',
                'text_tag'      => 'username,amount,order_id',
                'dltteid'       => '1207163152726693536',
                'email_body'    => File::get(public_path('sms_migrations/TRCDecined.html')),
                'created_at'    => time()
            )
        );

        DB::table('sms_templates')->insert(
            array(
                'slug'          => 'TRCOrder',
                'subject'       => 'TRCOrder',
                'text_tag'      => 'username,order_id,amount',
                'dltteid'       => '1207163152688611511',
                'email_body'    => File::get(public_path('sms_migrations/TRCOrder.html')),
                'created_at'    => time()
            )
        );

        DB::table('sms_templates')->insert(
            array(
                'slug'          => 'TRCPayment',
                'subject'       => 'TRCPayment',
                'text_tag'      => 'username,amount,order_id,transaction_no,invoice_no',
                'dltteid'       => '1207163152708088241',
                'email_body'    => File::get(public_path('sms_migrations/TRCPayment.html')),
                'created_at'    => time()
            )
        );

        DB::table('sms_templates')->insert(
            array(
                'slug'          => 'TRCPlanUpgrade',
                'subject'       => 'TRCPlanUpgrade',
                'text_tag'      => 'username,old_plan,new_plan',
                'dltteid'       => '1207163152679578285',
                'email_body'    => File::get(public_path('sms_migrations/TRCPlanUpgrade.html')),
                'created_at'    => time()
            )
        );

        DB::table('sms_templates')->insert(
            array(
                'slug'          => 'TRCWelcome',
                'subject'       => 'TRCWelcome',
                'text_tag'      => 'username',
                'dltteid'       => '1207163151959504406',
                'email_body'    => File::get(public_path('sms_migrations/TRCWelcome.html')),
                'created_at'    => time()
            )
        );

        DB::table('sms_templates')->insert(
            array(
                'slug'          => 'TRCtemppassword',
                'subject'       => 'TRCtemppassword',
                'text_tag'      => 'username,password',
                'dltteid'       => '1207163152664801312',
                'email_body'    => File::get(public_path('sms_migrations/TRCtemppassword.html')),
                'created_at'    => time()
            )
        );

        DB::table('sms_templates')->insert(
            array(
                'slug'          => 'TRCPlan',
                'subject'       => 'TRCPlan',
                'text_tag'      => 'username,plan',
                'dltteid'       => '1207163152671090529',
                'email_body'    => File::get(public_path('sms_migrations/TRCPlan.html')),
                'created_at'    => time()
            )
        );

        DB::table('sms_templates')->insert(
            array(
                'slug'          => 'TRCOTP',
                'subject'       => 'TRCOTP',
                'text_tag'      => 'username,otp',
                'dltteid'       => '1207163151947582842',
                'email_body'    => File::get(public_path('sms_migrations/TRCOTP.html')),
                'created_at'    => time()
            )
        );

        DB::table('sms_templates')->insert(
            array(
                'slug'          => 'TRCLogin',
                'subject'       => 'TRCLogin',
                'text_tag'      => 'username,email,password',
                'dltteid'       => '1207163152656559530',
                'email_body'    => File::get(public_path('sms_migrations/TRCLogin.html')),
                'created_at'    => time()
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
