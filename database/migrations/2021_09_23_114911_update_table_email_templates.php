<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableEmailTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('email_templates')->insert(
            array(
                'slug'          => 'user-otp-email',
                'subject'       => 'Tracesci Support : Confirmation OTP',
                'text_tag'      => 'username,otp',
                'email_body'    => File::get(public_path('email_migrations/user-otp-email.html')),
                'created_at'    => time()
            )
        );

        DB::table('email_templates')->insert(
            array(
                'slug'          => 'user-welcome-email',
                'subject'       => 'Tracesci Support : Welcome, verification In progress',
                'text_tag'      => 'username',
                'email_body'    => File::get(public_path('email_migrations/user-welcome-email.html')),
                'created_at'    => time()
            )
        );

        DB::table('email_templates')->insert(
            array(
                'slug'          => 'user-profile-approval',
                'subject'       => 'Tracesci Support : Your profile has been approved',
                'text_tag'      => 'username',
                'email_body'    => File::get(public_path('email_migrations/user-profile-approval.html')),
                'created_at'    => time()
            )
        );  
        
        DB::table('email_templates')->insert(
            array(
                'slug'          => 'user-profile-rejection',
                'subject'       => 'Tracesci Support : Your profile has been rejected',
                'text_tag'      => 'username',
                'email_body'    => File::get(public_path('email_migrations/user-profile-rejection.html')),
                'created_at'    => time()
            )
        );

        DB::table('email_templates')->insert(
            array(
                'slug'          => 'user-credential-email',
                'subject'       => 'Tracesci Support :  Login credentials',
                'text_tag'      => 'username,email,phone,password',
                'email_body'    => File::get(public_path('email_migrations/user-credential-email.html')),
                'created_at'    => time()
            )
        );

        DB::table('email_templates')->insert(
            array(
                'slug'          => 'user-forgot-password',
                'subject'       => 'Tracesci Support : Temporary Password',
                'text_tag'      => 'username,password',
                'email_body'    => File::get(public_path('email_migrations/user-forgot-password.html')),
                'created_at'    => time()
            )
        );

        DB::table('email_templates')->insert(
            array(
                'slug'          => 'user-new-plan-subscribe',
                'subject'       => 'Tracesci Support : You are subscribed to new plan',
                'text_tag'      => 'username,plan',
                'email_body'    => File::get(public_path('email_migrations/user-new-plan-subscribe.html')),
                'created_at'    => time()
            )
        );

        DB::table('email_templates')->insert(
            array(
                'slug'          => 'user-plan-switch',
                'subject'       => 'Tracesci Support : Your plan is updated.',
                'text_tag'      => 'username,newplan,oldplan',
                'email_body'    => File::get(public_path('email_migrations/user-plan-switch.html')),
                'created_at'    => time()
            )
        );

        DB::table('email_templates')->insert(
            array(
                'slug'          => 'user-order-confirmation',
                'subject'       => 'Tracesci Support : Order Confirmation',
                'text_tag'      => 'username,order_id,order_date,plan,quantity,amount',
                'email_body'    => File::get(public_path('email_migrations/user-order-confirmation.html')),
                'created_at'    => time()
            )
        );

        DB::table('email_templates')->insert(
            array(
                'slug'          => 'user-payment-confirmation',
                'subject'       => 'Tracesci Support : Payment confirmation.',
                'text_tag'      => 'username,amount,order_id,transaction_id,invoice_no',
                'email_body'    => File::get(public_path('email_migrations/user-payment-confirmation.html')),
                'created_at'    => time()
            )
        );

        DB::table('email_templates')->insert(
            array(
                'slug'          => 'user-payment-declined',
                'subject'       => 'Tracesci Support : Payment declined.',
                'text_tag'      => 'username,amount,order_id',
                'email_body'    => File::get(public_path('email_migrations/user-payment-declined.html')),
                'created_at'    => time()
            )
        );

        DB::table('email_templates')->insert(
            array(
                'slug'          => 'admin-user-registration-request',
                'subject'       => 'Tracesci Support : New registration Request',
                'text_tag'      => 'username,amount,name,phone,company,plan',
                'email_body'    => File::get(public_path('email_migrations/admin-user-registration-request.html')),
                'created_at'    => time()
            )
        );

        DB::table('email_templates')->insert(
            array(
                'slug'          => 'admin-new-order-received',
                'subject'       => 'Tracesci Support : New Order Received',
                'text_tag'      => 'username,order_id,order_date',
                'email_body'    => File::get(public_path('email_migrations/admin-new-order-received.html')),
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
        Schema::table('email_templates', function (Blueprint $table) {
            //
        });
    }
}
