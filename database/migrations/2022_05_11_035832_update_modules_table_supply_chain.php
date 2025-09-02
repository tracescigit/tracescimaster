<?php

use App\Models\Module;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateModulesTableSupplyChain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $vendor_modules = Module::where('type','2')->where('menu_position','>=','8')->get();

        foreach ($vendor_modules as $key => $module) {
            $module->menu_position = $module->menu_position+3;
            $module->save();
        }

        DB::table('modules')->insert(
            array(
                'type'          => '2',
                'menu_position' => '8',
                'has_sub_menu'  => '1',
                'base_route'    => 'vendor-supply-chain-roles',
                'name'          => 'Supply Chain Roles',
                'icon'          => 'git-pull-request',
                'slug'          => Str::slug('Supply Chain Roles'),
                'view_routes'   => json_encode([
                    'vendor-supply-chain-roles'
                ]),
                'modify_routes' => json_encode([
                    'vendor-create-supply-chain-roles','vendor-store-supply-chain-roles','vendor-edit-supply-chain-roles','vendor-update-supply-chain-roles','vendor-destroy-supply-chain-roles'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('modules')->insert(
            array(
                'type'          => '2',
                'menu_position' => '9',
                'has_sub_menu'  => '1',
                'base_route'    => 'vendor-supply-chain-users',
                'name'          => 'Supply Chain Users',
                'icon'          => 'user-plus',
                'slug'          => Str::slug('Supply Chain Users'),
                'view_routes'   => json_encode([
                    'vendor-supply-chain-users'
                ]),
                'modify_routes' => json_encode([
                    'vendor-create-supply-chain-users','vendor-store-supply-chain-users','vendor-edit-supply-chain-users','vendor-update-supply-chain-users','vendor-destroy-supply-chain-users'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('modules')->insert(
            array(
                'type'          => '2',
                'menu_position' => '10',
                'has_sub_menu'  => '0',
                'base_route'    => 'vendor-supply-chain-management',
                'name'          => 'Supply Chain Managenemt',
                'icon'          => 'link',
                'slug'          => Str::slug('Supply Chain Management'),
                'view_routes'   => json_encode([
                    'vendor-supply-chain-management'
                ]),
                'modify_routes' => json_encode([
                    'vendor-create-supply-chain-management','vendor-store-supply-chain-management','vendor-edit-supply-chain-management','vendor-update-supply-chain-management','vendor-destroy-supply-chain-management','vendor-get-supply-chain-management-users','vendor-get-supply-chain-management-user-data','vendor-show-supply-chain-management'
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
