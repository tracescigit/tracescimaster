<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrintingCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('printing_costs', function (Blueprint $table) {
            $table->id();
            $table->float('black_and_white')->nullable();
            $table->float('black_and_white_price_usd')->nullable();
            $table->float('color')->nullable();
            $table->float('color_price_usd')->nullable();
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
        Schema::dropIfExists('printing_costs');
    }
}
