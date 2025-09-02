<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateScanHistoriesGrnuine extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('scan_histories', function (Blueprint $table) {
            $table->enum('genuine',['0','1'])->default('0')->after('code_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scan_histories', function (Blueprint $table) {
            //
        });
    }
}
