<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCreditsTableGst extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credits', function (Blueprint $table) {
            $table->float('cgst')->nullable()->after('payment_id');
            $table->float('sgst')->nullable()->after('cgst');
            $table->float('igst')->nullable()->after('sgst');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credits', function (Blueprint $table) {
            $table->dropColumn('cgst');
            $table->dropColumn('sgst');
            $table->dropColumn('igst');
        });
    }
}
