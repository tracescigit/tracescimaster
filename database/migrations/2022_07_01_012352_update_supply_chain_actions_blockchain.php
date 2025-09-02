<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSupplyChainActionsBlockchain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supply_chain_actions', function (Blueprint $table) {
            $table->text('parent_aggregation_unique_id')->nullable()->after('aggregation_unique_id');
            $table->text('parent_hash')->nullable()->after('parent_aggregation_unique_id');
            $table->text('current_hash')->nullable()->after('parent_hash');
            $table->text('block_hash')->nullable()->after('current_hash');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supply_chain_actions', function (Blueprint $table) {
            //
        });
    }
}
