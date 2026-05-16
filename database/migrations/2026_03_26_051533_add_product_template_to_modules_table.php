<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AddProductTemplateToModulesTable extends Migration
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
                'type'          => '2',
                'menu_position' => '17',
                'has_sub_menu'  => '1',
                'base_route'    => 'vendor-products-template',
                'name'          => 'Product Template',
                'icon'          => 'link',
                'slug'          => Str::slug('Product Template'),
                'view_routes'   => json_encode([
                    'vendor-products-template',
                    'vendor-show-products-template'

                ]),
                'modify_routes' => json_encode([
                    'vendor-create-products-template',
                    'vendor-store-products-template',
                    'vendor-edit-products-template',
                    'vendor-update-products-template'
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
        DB::table('modules')->where('slug', 'product-template')->delete();
    }
}
