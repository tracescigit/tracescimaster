<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelOrderLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('label_order_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('reference')->nullable();
            $table->string('initial_status',200)->nullable();
            $table->string('current_status',200)->nullable();
            $table->text('remarks')->nullable();
            $table->bigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('label_order_logs');
    }
}
