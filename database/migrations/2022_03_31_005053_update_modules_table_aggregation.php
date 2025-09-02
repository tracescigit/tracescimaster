<?php

use App\Models\Module;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateModulesTableAggregation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $vendor_modules = Module::where('type','2')->where('menu_position','>=','6')->get();

        foreach ($vendor_modules as $key => $module) {
            $module->menu_position = $module->menu_position+1;
            $module->save();
        }

        DB::table('modules')->insert(
            array(
                'type'          => '2',
                'menu_position' => '6',
                'has_sub_menu'  => '1',
                'base_route'    => 'vendor-aggregations',
                'name'          => 'Aggregations',
                'icon'          => 'git-merge',
                'slug'          => Str::slug('Aggregations'),
                'view_routes'   => json_encode([
                    'vendor-aggregations'
                ]),
                'modify_routes' => json_encode([
                    'vendor-create-aggregations','vendor-store-aggregations','vendor-edit-aggregations','vendor-update-aggregations','vendor-destroy-aggregations'
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
        Schema::table('modules', function (Blueprint $table) {
            //
        });
    }
}
