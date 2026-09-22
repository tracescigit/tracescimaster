<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UpdateDemoSchedule extends Migration
{
    public function up()
    {
        DB::table('email_templates')->insert(
            array(
                'slug'          => 'demo-schedule-email',
                'subject'       => 'Tracesci Demo Schedule : Demo Scheduled',
                'text_tag'      => 'username,demo_date,demo_time,message,link',
                'email_body'    => File::get(public_path('email_migrations/user-demo-schedule.html')),
                'created_at'    => time()
            )
        );
    }

    public function down()
    {
        DB::table('email_templates')->where('slug', 'demo-schedule-email')->delete();
    }
}