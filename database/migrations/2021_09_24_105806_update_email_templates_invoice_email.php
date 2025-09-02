<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEmailTemplatesInvoiceEmail extends Migration
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
                'slug'          => 'user-invoice-generation-email',
                'subject'       => 'Tracesci Support : Invoice generated',
                'text_tag'      => 'username,amount,link',
                'email_body'    => File::get(public_path('email_migrations/user-invoice-generation-email.html')),
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
