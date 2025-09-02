<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashbacks', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->date('from')->nullable();
            $table->date('to')->nullable();   
            $table->integer('quantity')->nullable();
            $table->text('items')->nullable();
            $table->string('reshuffle_items')->nullable();
            $table->string('status')->nullable(); 
            $table->string('allow_multiple')->nullable(); 
            $table->text('description')->nullable();
            $table->text('log')->nullable();
            $table->text('codes')->nullable();
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
        Schema::dropIfExists('cashbacks');
    }
}
