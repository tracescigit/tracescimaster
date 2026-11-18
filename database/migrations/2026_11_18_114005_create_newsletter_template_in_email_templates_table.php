<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
class CreateNewsletterTemplateInEmailTemplatesTable extends Migration
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
                'slug'          => 'newsletter-email',
                'subject'       => 'Thank You for Subscribing to Our Newsletter',
                'text_tag'      =>'email',
                'email_body'    => File::get(public_path('email_migrations/newsletter.html')),
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
     DB::table('email_templates')->where('slug', 'newsletter-email')->delete();

    }
}
