<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateScanHistoriesTablePhone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scan_histories', function (Blueprint $table) {
            $table->string('phone_code',20)->nullable()->after('id');
            $table->string('phone',50)->nullable()->after('phone_code');
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
            $table->dropColumn('phone_code');
            $table->dropColumn('phone');
        });
    }
}
