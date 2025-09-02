<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('alerts', function (Blueprint $table) {
            $table->string('batch',200)->nullable();
            $table->string('issue_type',200)->nullable();
            $table->text('image')->nullable();
            $table->enum('type',['0','1'])->comment('0 = alert, 1 = report');
            $table->enum('status',['0','1'])->default('0')->comment('0-Open, 1-Closed');
            $table->string('admin_comment',200)->nullable();
            $table->string('manufacturer_comment',200)->nullable();
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
            $table->dropColumn('batch');
            $table->dropColumn('issue_type');
            $table->dropColumn('image');
            $table->dropColumn('type');
            $table->dropColumn('status');
            $table->dropColumn('admin_comment');
            $table->dropColumn('manufacturer_comment');
        });
    }
}
