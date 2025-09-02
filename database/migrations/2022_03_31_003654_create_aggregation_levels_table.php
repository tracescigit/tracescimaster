<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateAggregationLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aggregation_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->smallInteger('level');
            $table->timestamps();
        });

        DB::table('aggregation_levels')->insert(
            array(
                'name'          => 'Primary',
                'level'         => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('aggregation_levels')->insert(
            array(
                'name'          => 'Secondary',
                'level'         => 2,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('aggregation_levels')->insert(
            array(
                'name'          => 'Tertiary',
                'level'         => 3,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            )
        );

        DB::table('aggregation_levels')->insert(
            array(
                'name'          => 'Pallette',
                'level'         => 4,
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
        Schema::dropIfExists('aggregation_levels');
    }
}
