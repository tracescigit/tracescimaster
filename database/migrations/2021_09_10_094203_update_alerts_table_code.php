<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAlertsTableCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('alerts', function (Blueprint $table) {
           $table->bigInteger('code_id')->unsigned()->nullable()->after('batch_id');
           $table->foreign('code_id')
           ->references('id')->on('codes')
           ->onDelete('cascade');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alerts', function (Blueprint $table) {
            //
        });
    }
}
