<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['1','2'])->nullable()->comment('1-Admin, 2-Vendor');
            $table->string('name',200);
            $table->timestamps();
        });

        DB::table('roles')->insert([
            'type'=> '1',
            'name'=> 'Management',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()

        ]);
        DB::table('roles')->insert([
            'type'=> '1',
            'name'=> 'Finance',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()

        ]);
        DB::table('roles')->insert([
            'type'=> '1',
            'name'=> 'Operations',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()

        ]);
        DB::table('roles')->insert([
            'type'=> '1',
            'name'=> 'Onboarding',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()

        ]);
        DB::table('roles')->insert([
            'type'=> '1',
            'name'=> 'Service',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()

        ]);
        DB::table('roles')->insert([
            'type'=> '1',
            'name'=> 'Executive',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()

        ]);

        DB::table('roles')->insert([
            'type'=> '2',
            'name'=> 'Audit Team',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()

        ]);

        DB::table('roles')->insert([
            'type'=> '2',
            'name'=> 'Management',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()

        ]);

        DB::table('roles')->insert([
            'type'=> '2',
            'name'=> 'Finance',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()

        ]);
        DB::table('roles')->insert([
            'type'=> '2',
            'name'=> 'Operations',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()

        ]);
        DB::table('roles')->insert([
            'type'=> '2',
            'name'=> 'Production',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()

        ]);
        DB::table('roles')->insert([
            'type'=> '2',
            'name'=> 'Logistics',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()

        ]);
        DB::table('roles')->insert([
            'type'=> '2',
            'name'=> 'Warehouse',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()

        ]);
        DB::table('roles')->insert([
            'type'=> '2',
            'name'=> 'Executive',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
