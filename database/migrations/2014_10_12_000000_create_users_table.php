<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            $table->enum('type',['0','1','2','3','4'])->nullable()->comment('0-Public User, 1-Admin, 2-Vendor, 3-Inspector, 4-Employee');
            $table->string('name')->nullable();
            $table->string('email',100)->nullable()->unique();
            $table->string('phone_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('dob')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('photo')->nullable();
            $table->enum('gender', ['m', 'f', 'o', 'u'])->default('u')->comment('m-Male , f-Female , o-Other , u-Unspecified');
            $table->integer('city_id')->nullable();
            $table->text('address_one')->nullable();
            $table->text('address_two')->nullable();
            $table->string('zip', 20)->nullable();           
            $table->enum('status', ['0', '1', '2'])->default('0')->comment('0-Pending, 1-Active, 2-Blocked');
            $table->enum('active',['0','1'])->default('0');
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            array(
                'name'              => 'TRACESCI',
                'type'              => '1',
                'email'             => 'tnt@yopmail.com',
                'username'          => 'tnt@yopmail.com',
                'password'          => bcrypt('Admin#123'),
                'active'            => '1',  
                'status'            => '1',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
