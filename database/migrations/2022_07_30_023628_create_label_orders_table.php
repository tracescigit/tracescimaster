<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('label_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
            $table->string('start_code_no')->nullable();
            $table->text('description')->nullable();
            $table->float('rate')->nullable();
            $table->integer('quantity')->nullable();
            $table->float('subtotal')->nullable();
            $table->float('gst')->nullable();
            $table->float('amount')->nullable();
            $table->string('image_url')->nullable();
            $table->enum('add_company_logo',['0','1'])->default('0');
            $table->enum('sr_no_below_2d_code',['0','1'])->default('0');
            $table->enum('full_cmyk_color_print',['0','1'])->default('0');
            $table->string('rz_order_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('status')->nullable();
            $table->smallInteger('dispatch_status')->default('0');
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
        Schema::dropIfExists('label_orders');
    }
}
