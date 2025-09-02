<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInvoicesTableGst extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
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
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('cgst');
            $table->dropColumn('sgst');
            $table->dropColumn('igst');
        });
    }
}
