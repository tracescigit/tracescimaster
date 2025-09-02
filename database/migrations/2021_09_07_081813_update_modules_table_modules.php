<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class UpdateModulesTableModules extends Migration
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
                'menu_position' => '1',
                'base_route'    => 'admin',
                'name'          => 'Dashboard',
                'icon'          => 'home',
                'slug'          => Str::slug('Dashboard'),
                'view_routes'   => json_encode([
                    'admin'
                ]),
                'modify_routes' => json_encode([
                    'admin'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('modules')->insert(
            array(
                'type'          => '1',
                'menu_position' => '2',
                'has_sub_menu'  => '1',
                'base_route'    => 'admin-registrations',
                'name'          => 'Registrations',
                'icon'          => 'users',
                'slug'          => Str::slug('Registrations'),
                'view_routes'   => json_encode([
                    'admin-registrations'
                ]),
                'modify_routes' => json_encode([
                    'admin-create-registrations','admin-store-registrations','admin-edit-registrations','admin-update-registrations'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('modules')->insert(
            array(
                'type'          => '1',
                'menu_position' => '3',
                'has_sub_menu'  => '1',
                'base_route'    => 'admin-plans',
                'name'          => 'Plans',
                'icon'          => 'send',
                'slug'          => Str::slug('Plans'),
                'view_routes'   => json_encode([
                    'admin-plans'
                ]),
                'modify_routes' => json_encode([
                    'admin-create-plans','admin-store-plans','admin-edit-plans','admin-update-plans','admin-destroy-plans'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('modules')->insert(
            array(
                'type'          => '1',
                'menu_position' => '4',
                'has_sub_menu'  => '1',
                'base_route'    => 'admin-topups',
                'name'          => 'Topups',
                'icon'          => 'plus',
                'slug'          => Str::slug('Topups'),
                'view_routes'   => json_encode([
                    'admin-topups'
                ]),
                'modify_routes' => json_encode([
                    'admin-create-topups','admin-store-topups','admin-edit-topups','admin-update-topups','admin-destroy-topups'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('modules')->insert(
            array(
                'type'          => '1',
                'menu_position' => '5',
                'has_sub_menu'  => '1',
                'base_route'    => 'admin-offers',
                'name'          => 'Offers',
                'icon'          => 'percent',
                'slug'          => Str::slug('Offers'),
                'view_routes'   => json_encode([
                    'admin-offers'
                ]),
                'modify_routes' => json_encode([
                    'admin-create-offers','admin-store-offers','admin-edit-offers','admin-update-offers','admin-destroy-offers'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('modules')->insert(
            array(
                'type'          => '1',
                'menu_position' => '6',
                'base_route'    => 'admin-invoices',
                'name'          => 'Invoices',
                'icon'          => 'printer',
                'slug'          => Str::slug('Invoices'),
                'view_routes'   => json_encode([
                    'admin-invoices','admin-show-invoices','admin-download-invoice'
                ]),
                'modify_routes' => json_encode([
                    'admin-update-invoices','admin-invoice-transaction','admin-invoice-remove'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('modules')->insert(
            array(
                'type'          => '1',
                'menu_position' => '7',
                'base_route'    => 'admin-codes',
                'name'          => 'QR Codes',
                'icon'          => 'command',
                'slug'          => Str::slug('QR Codes'),
                'view_routes'   => json_encode([
                    'admin-codes'
                ]),
                'modify_routes' => json_encode([
                    'admin-codes'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('modules')->insert(
            array(
                'type'          => '1',
                'menu_position' => '8',
                'base_route'    => 'admin-scan-history',
                'name'          => 'Scan History',
                'icon'          => 'maximize',
                'slug'          => Str::slug('Scan History'),
                'view_routes'   => json_encode([
                    'admin-scan-history','admin-show-scanhistory'
                ]),
                'modify_routes' => json_encode([
                    'admin-scan-history','admin-show-scanhistory'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('modules')->insert(
            array(
                'type'          => '1',
                'menu_position' => '9',
                'base_route'    => 'admin-alerts',
                'name'          => 'Alerts',
                'icon'          => 'bell',
                'slug'          => Str::slug('alerts'),
                'view_routes'   => json_encode([
                    'admin-alerts','admin-show-alerts'
                ]),
                'modify_routes' => json_encode([
                    'admin-act-alerts','admin-alerts-assign'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('modules')->insert(
            array(
                'type'          => '1',
                'menu_position' => '10',
                'base_route'    => 'admin-reports',
                'name'          => 'App Reports',
                'icon'          => 'file-text',
                'slug'          => Str::slug('App Reports'),
                'view_routes'   => json_encode([
                    'admin-reports','admin-show-reports'
                ]),
                'modify_routes' => json_encode([
                    'admin-reports','admin-show-reports'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );    

        DB::table('modules')->insert(
            array(
                'type'          => '1',
                'menu_position' => '11',
                'base_route'    => 'admin-lost-damage',
                'name'          => 'Report Lost/Damage',
                'icon'          => 'alert-triangle',
                'slug'          => Str::slug('Report Lost/Damage'),
                'view_routes'   => json_encode([
                    'admin-lost-damage','admin-lost-damage-show'
                ]),
                'modify_routes' => json_encode([
                    'admin-lost-damage','admin-lost-damage-show'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('modules')->insert(
            array(
                'type'          => '1',
                'menu_position' => '12',
                'has_sub_menu'  => '1',
                'base_route'    => 'admin-users',
                'name'          => 'Users',
                'icon'          => 'users',
                'slug'          => Str::slug('Users'),
                'view_routes'   => json_encode([
                    'admin-users'
                ]),
                'modify_routes' => json_encode([
                    'admin-create-users','admin-edit-users','admin-store-users','admin-update-users'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );   

        DB::table('modules')->insert(
            array(
                'type'          => '1',
                'menu_position' => '13',
                'base_route'    => 'admin-profile',
                'name'          => 'Profile',
                'icon'          => 'user',
                'slug'          => Str::slug('Profile'),
                'view_routes'   => json_encode([
                    'admin-profile'
                ]),
                'modify_routes' => json_encode([
                    'admin-update-profile'
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
        DB::table('modules')->where('type','1')->delete();
    }
}
