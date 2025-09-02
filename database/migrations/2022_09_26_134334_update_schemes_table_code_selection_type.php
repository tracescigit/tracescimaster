<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSchemesTableCodeSelectionType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schemes', function (Blueprint $table) {
            $table->bigInteger('product_id')->unsigned()->nullable()->after('items');
            $table->bigInteger('batch_id')->unsigned()->nullable()->after('product_id');
            $table->string('product_selection_type')->nullable()->after('batch_id');
            $table->string('reshuffle_items')->nullable()->after('product_selection_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schemes', function (Blueprint $table) {
            //
        });
    }
}
