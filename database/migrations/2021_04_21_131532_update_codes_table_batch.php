<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCodesTableBatch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('codes', function (Blueprint $table) {
            //
            $table->string('batch')->nullable();
            $table->string('code_data')->nullable();
            $table->enum('exported', ['0','1'])->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('codes', function (Blueprint $table) {
            //
            $table->dropColumn('batch');
            $table->dropColumn('code_data');
            $table->dropColumn('exported');
        });
    }
}
