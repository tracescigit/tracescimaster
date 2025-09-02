<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyChainAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_chain_alerts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('aggregation_id')->nullable()->unsigned();
            $table->foreign('aggregation_id')->references('id')->on('aggregations')->onDelete('cascade');
            $table->integer('scanned_by')->nullable()->unsigned();
            $table->foreign('scanned_by')->references('id')->on('users')->onDelete('cascade');
            $table->text('alert_message')->nullable();
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
        Schema::dropIfExists('supply_chain_alerts');
    }
}
