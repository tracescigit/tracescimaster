<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->foreign('product_id')
            ->references('id')->on('products')
            ->onDelete('cascade');
            $table->string('gs1_code')->nullable();   
            $table->string('code')->nullable();
            $table->string('mfg_date')->nullable();
            $table->string('exp_date')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('status',['0','1'])->default('0')->comment('0 = Inactive, 1 = Active');
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
        Schema::dropIfExists('batches');
    }
}
