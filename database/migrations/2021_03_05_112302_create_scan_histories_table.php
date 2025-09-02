<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScanHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scan_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('code_id')->nullable()->unsigned();
            $table->foreign('code_id')->references('id')->on('codes')->onDelete('cascade');
            $table->text('location')->nullable();
            $table->integer('scan_count')->default(0);
            $table->integer('scanned_by')->nullable()->unsigned();
            $table->foreign('scanned_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('device_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('feedback')->nullable();
            $table->text('images')->nullable();
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
        Schema::dropIfExists('scan_histories');
    }
}
