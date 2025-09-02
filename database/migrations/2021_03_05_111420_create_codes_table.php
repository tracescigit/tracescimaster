<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codes', function (Blueprint $table) {
            $table->id();
            $table->enum('code_type',['0','1'])->default('0')->comment('0-Normal code, 1-Encrypted code');
            $table->integer('product_id')->unsigned()->nullable();
            $table->string('url')->nullable();
            $table->text('qr_code')->nullable();
            $table->string('key')->nullable();
            $table->enum('status',['0','1'])->default('0')->comment('0-Inactive, 1-Active');
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
        Schema::dropIfExists('codes');
    }
}
