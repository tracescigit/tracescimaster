<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class UpdateModulesTableVendorModules extends Migration
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
                'menu_position' => '1',
                'base_route'    => 'vendor',
                'name'          => 'Dashboard',
                'icon'          => 'home',
                'slug'          => Str::slug('Dashboard'),
                'view_routes'   => json_encode([
                    'vendor'
                ]),
                'modify_routes' => json_encode([
                    'vendor'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('modules')->insert(
            array(
                'type'          => '2',
                'menu_position' => '2',
                'base_route'    => 'vendor-credits',
                'name'          => 'Plans & Credits',
                'icon'          => 'users',
                'slug'          => Str::slug('Plans & Credits'),
                'view_routes'   => json_encode([
                    'vendor-credits','vendor-show-credits','vendor-buy-credits','vendor-make-payment'
                ]),
                'modify_routes' => json_encode([
                    'vendor-get-offer','vendor-order','vendor-transaction'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('modules')->insert(
            array(
                'type'          => '2',
                'menu_position' => '3',
                'base_route'    => 'vendor-invoices',
                'name'          => 'My Invoices',
                'icon'          => 'users',
                'slug'          => Str::slug('My Invoices'),
                'view_routes'   => json_encode([
                    'vendor-invoices','vendor-show-invoices','vendor-download-invoice'
                ]),
                'modify_routes' => json_encode([
                    'vendor-invoice-transaction','vendor-invoice-remove'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('modules')->insert(
            array(
                'type'          => '2',
                'menu_position' => '4',
                'has_sub_menu'  => '1',
                'base_route'    => 'vendor-products',
                'name'          => 'Products',
                'icon'          => 'users',
                'slug'          => Str::slug('Products'),
                'view_routes'   => json_encode([
                    'vendor-products'
                ]),
                'modify_routes' => json_encode([
                    'vendor-create-products','vendor-store-products','vendor-edit-products','vendor-update-products','vendor-destroy-products'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('modules')->insert(
            array(
                'type'          => '2',
                'menu_position' => '5',
                'has_sub_menu'  => '1',
                'base_route'    => 'vendor-batches',
                'name'          => 'Batches',
                'icon'          => 'users',
                'slug'          => Str::slug('Batches'),
                'view_routes'   => json_encode([
                    'vendor-batches'
                ]),
                'modify_routes' => json_encode([
                    'vendor-create-batches','vendor-store-batches','vendor-edit-batches','vendor-update-batches','vendor-destroy-batches'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('modules')->insert(
            array(
                'type'          => '2',
                'menu_position' => '6',
                'base_route'    => 'vendor-codes',
                'name'          => 'QR Codes',
                'icon'          => 'command',
                'slug'          => Str::slug('QR Codes'),
                'view_routes'   => json_encode([
                    'vendor-codes'
                ]),
                'modify_routes' => json_encode([
                    'vendor-action-codes','vendor-get-order-items','vendor-act-deact-codes'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('modules')->insert(
            array(
                'type'          => '2',
                'menu_position' => '7',
                'base_route'    => 'vendor-scan-history',
                'name'          => 'Scan History',
                'icon'          => 'maximize',
                'slug'          => Str::slug('Scan History'),
                'view_routes'   => json_encode([
                    'vendor-scan-history','vendor-show-scanhistory'
                ]),
                'modify_routes' => json_encode([
                    'vendor-scan-history','vendor-show-scanhistory'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        ); 

        DB::table('modules')->insert(
            array(
                'type'          => '2',
                'menu_position' => '8',
                'base_route'    => 'vendor-alerts',
                'name'          => 'Alerts',
                'icon'          => 'bell',
                'slug'          => Str::slug('alerts'),
                'view_routes'   => json_encode([
                    'vendor-alerts','vendor-show-alerts'
                ]),
                'modify_routes' => json_encode([
                    'vendor-act-alerts','vendor-alerts-assign'
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
                'base_route'    => 'vendor-reports',
                'name'          => 'App Reports',
                'icon'          => 'file-text',
                'slug'          => Str::slug('App Reports'),
                'view_routes'   => json_encode([
                    'vendor-reports','vendor-show-reports'
                ]),
                'modify_routes' => json_encode([
                    'vendor-reports','vendor-show-reports'
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
                'base_route'    => 'lost-damage',
                'name'          => 'Report Lost/Damage',
                'icon'          => 'alert-triangle',
                'slug'          => Str::slug('Report Lost/Damage'),
                'view_routes'   => json_encode([
                    'lost-damage','lost-damage-show'
                ]),
                'modify_routes' => json_encode([
                    'lost-damage-create','lost-damage-store'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('modules')->insert(
            array(
                'type'          => '2',
                'menu_position' => '11',
                'has_sub_menu'  => '1',
                'base_route'    => 'vendor-users',
                'name'          => 'Users',
                'icon'          => 'users',
                'slug'          => Str::slug('Users'),
                'view_routes'   => json_encode([
                    'vendor-users'
                ]),
                'modify_routes' => json_encode([
                    'vendor-create-users','vendor-edit-users','vendor-store-users','vendor-update-user'
                ]),
                'status'        => '1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );   
        
        DB::table('modules')->insert(
            array(
                'type'          => '2',
                'menu_position' => '12',
                'base_route'    => 'vendor-profile',
                'name'          => 'Profile',
                'icon'          => 'user',
                'slug'          => Str::slug('Profile'),
                'view_routes'   => json_encode([
                    'vendor-profile'
                ]),
                'modify_routes' => json_encode([
                    'vendor-update-profile'
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
        DB::table('modules')->where('type','2')->delete();
    }
}
