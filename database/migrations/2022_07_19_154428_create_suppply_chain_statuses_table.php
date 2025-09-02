<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppplyChainStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppply_chain_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->string('placeholder')->nullable();
            $table->timestamps();
        });

        DB::table('suppply_chain_statuses')->insert(
            [
                'status' => 'Received',
                'placeholder' => 'Received in good condition'
            ]
        );

        DB::table('suppply_chain_statuses')->insert(
            [
                'status' => 'Shipped',
                'placeholder' => 'Shipping Details are:-'
            ]
        );

        DB::table('suppply_chain_statuses')->insert(
            [
                'status' => 'Received as damaged',
                'placeholder' => 'Package damaged from'
            ]
        );

        DB::table('suppply_chain_statuses')->insert(
            [
                'status' => 'Return product',
                'placeholder' => 'Reason'
            ]
        );

        DB::table('suppply_chain_statuses')->insert(
            [
                'status' => 'Recalled product',
                'placeholder' => 'Reason'
            ]
        );

        DB::table('suppply_chain_statuses')->insert(
            [
                'status' => 'Dispose',
                'placeholder' => 'Reason'
            ]
        );

        DB::table('suppply_chain_statuses')->insert(
            [
                'status' => 'Other',
                'placeholder' => null
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppply_chain_statuses');
    }
}
