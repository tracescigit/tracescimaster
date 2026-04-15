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
                'name'          => 'Blog',
                'icon'          => 'Blog',
                'slug'          => Str::slug('Blog'),
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
                'base_route'    => 'admin-book-demo',
                'name'          => 'Book Demo',
                'icon'          => 'bookmark',
                'slug'          => Str::slug('Book Demo'),
                'view_routes'   => json_encode([
                    'admin-book-demo','admin-book-demo-views'
                ]),
                'modify_routes' => json_encode([
                    'admin-book-demo-create','admin-book-demo-update'
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
        DB::table('modules')->where('slug',Str::slug(['Book Demo','Events','Blog']))->delete();
    }
}
