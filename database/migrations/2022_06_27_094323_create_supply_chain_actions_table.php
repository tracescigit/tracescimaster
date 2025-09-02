<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyChainActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_chain_actions', function (Blueprint $table) {
            $table->id();
            $table->string('aggregation_unique_id')->nullable();
            $table->integer('scan_id')->nullable();
            $table->string('action')->nullable();
            $table->integer('action_by')->nullable()->unsigned();
            $table->foreign('action_by')->references('id')->on('users')->onDelete('cascade');
            $table->integer('action_for')->nullable()->unsigned();
            $table->foreign('action_for')->references('id')->on('users')->onDelete('cascade');
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('supply_chain_actions');
    }
}
