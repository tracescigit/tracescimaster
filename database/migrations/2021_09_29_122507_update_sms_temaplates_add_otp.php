<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSmsTemaplatesAddOtp extends Migration
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
                'slug'          => 'TRCOTP',
                'subject'       => 'TRCOTP',
                'text_tag'      => 'username,otp',
                'dltteid'       => '1207163255106963341',
                'email_body'    => File::get(public_path('sms_migrations/TRCOTP.html')),
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
        Schema::table('sms_templates', function (Blueprint $table) {
            //
        });
    }
}
