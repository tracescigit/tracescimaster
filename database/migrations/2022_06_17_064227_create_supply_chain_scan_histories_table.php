<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyChainScanHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_chain_scan_histories', function (Blueprint $table) {
            $table->id();
            $table->string('aggregation_unique_id')->nullable();
            $table->text('location')->nullable();
            $table->integer('scanned_by')->nullable()->unsigned();
            $table->foreign('scanned_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('device_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supply_chain_scan_histories');
    }
}
