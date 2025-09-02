<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('brand')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();   
            $table->string('unique_id')->nullable();
            $table->float('price',15)->nullable(); 
            $table->string('image_url')->nullable();
            $table->string('gs1_code')->nullable();   
            $table->string('batch_code')->nullable();
            $table->string('mfg_date')->nullable();
            $table->string('exp_date')->nullable();
            $table->text('description')->nullable();
            $table->text('custom_text')->nullable();   
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
        Schema::dropIfExists('products');
    }
}
