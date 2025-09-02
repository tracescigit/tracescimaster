<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title',200)->nullable();
            $table->string('code',200)->nullable();
            $table->string('value',200)->nullable();
            $table->enum('type',['0','1'])->default('0')->comment = "0-price,1-percentage";
            $table->string('description',200)->nullable();
            $table->string('image_url',200)->nullable();
            $table->integer('limit')->nullable();
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
            $table->enum('status',['0','1'])->default(1)->comment('0 : Pending,1 : Active');
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
        Schema::dropIfExists('offers');
    }
}
