<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->nullable()->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('product_name')->nullable();
            $table->integer('scanned_by')->nullable()->unsigned();
            $table->foreign('scanned_by')->references('id')->on('users')->onDelete('cascade');
            $table->integer('vendor_assigned_to')->unsigned()->nullable();
            $table->bigInteger('batch_id')->nullable()->unsigned();
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
            $table->text('location')->nullable();
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
        Schema::dropIfExists('alerts');
    }
}
