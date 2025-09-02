<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['1','2'])->nullable()->comment('1-Admin, 2-Vendor');
            $table->smallInteger('menu_position')->nullable();
            $table->enum('has_sub_menu',['0','1'])->default('0')->comment('0-No, 1-Yes');
            $table->string('name',200)->nullable();
            $table->string('slug',200)->nullable();
            $table->string('icon',200)->nullable();
            $table->string('base_route',200)->nullable();
            $table->text('view_routes')->nullable();
            $table->text('modify_routes')->nullable();
            $table->enum('status',['0','1'])->default('1')->comment('0-Inactive, 1-Active');
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
        Schema::dropIfExists('modules');
    }
}
