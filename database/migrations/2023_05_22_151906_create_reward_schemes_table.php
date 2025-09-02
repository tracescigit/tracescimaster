<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardSchemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reward_schemes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('title')->nullable();
            $table->float('points')->nullable();
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->bigInteger('batch_id')->unsigned()->nullable();
            $table->string('product_selection_type')->nullable();
            $table->text('items')->nullable();
            $table->text('codes')->nullable();
            $table->string('status')->nullable();
            $table->text('log')->nullable();
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
        Schema::dropIfExists('reward_schemes');
    }
}
