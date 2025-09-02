<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTablePaymentGateway extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('razorpay_id');
            $table->dropColumn('razorpay_token');
            $table->string('payment_gateway')->nullable()->after('status');
            $table->string('payment_gateway_id')->nullable()->after('payment_gateway');
            $table->string('payment_gateway_token')->nullable()->after('payment_gateway_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
