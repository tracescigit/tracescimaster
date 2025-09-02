<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Module;
use Carbon\Carbon;

class UpdateModulesTableSchemes extends Migration
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
                'menu_position' => '11',
                'has_sub_menu'  => '0',
                'base_route'    => 'vendor-schemes',
                'name'          => 'Schemes',
                'icon'          => 'link',
                'slug'          => Str::slug('Schemes'),
                'view_routes'   => json_encode([
                    'vendor-schemes','vendor-show-schemes'
                ]),
                'modify_routes' => json_encode([
                    'vendor-create-schemes','vendor-store-schemes','vendor-edit-schemes','vendor-update-schemes','vendor-execute-schemes','vendor-finalize-schemes'
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
