<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AddNewFieldsInModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('modules')->insert(
            array(
                'type'          => '1',
                'menu_position' => '14',
                'base_route'    => 'admin-blog',
                'name'          => 'Blogs',
                'icon'          => 'file',
                'slug'          => Str::slug('Blogs'),
                'view_routes'   => json_encode([
                    'admin-blog','admin-blog-view'
                ]),
                'modify_routes' => json_encode([
                    'admin-blog-create','admin-blog-update'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

         DB::table('modules')->insert(
            array(
                'type'          => '1',
                'menu_position' => '15',
                'base_route'    => 'admin-events',
                'name'          => 'Events',
                'icon'          => 'calendar',
                'slug'          => Str::slug('Events'),
                'view_routes'   => json_encode([
                    'admin-events','admin-events-views'
                ]),
                'modify_routes' => json_encode([
                    'admin-events-create','admin-events-update'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

         DB::table('modules')->insert(
            array(
                'type'          => '1',
                'menu_position' => '16',
                'base_route'    => 'admin-demo-schedule',
                'name'          => 'Demo Schedule',
                'icon'          => 'bookmark',
                'slug'          => Str::slug('Demo Schedule'),
                'view_routes'   => json_encode([
                    'admin-demo-schedule','admin-demo-schedule-views'
                ]),
                'modify_routes' => json_encode([
                    'demo-schedule-create','demo-schedule-store','demo-schedule-update','demo-schedule-edit'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
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
        DB::table('modules')->whereIn('slug',[Str::slug('Book Demo'),Str::slug('Events'),Str::slug('Blogs')])->delete();
    }
}
