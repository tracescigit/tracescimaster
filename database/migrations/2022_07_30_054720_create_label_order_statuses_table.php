<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelOrderStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('label_order_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('code',2)->nullable();
            $table->string('title',50)->nullable();
            $table->boolean('further_action')->default(false);
        });

        DB::table('label_order_statuses')->insert(array(
            [
                'code'=>'0',
                'title'=>'Pending',
                'further_action'=>true
            ],[
                'code'=>'1',
                'title'=>'In Progress',
                'further_action'=>true
            ],[
                'code'=>'2',
                'title'=>'Ready to Dispatch',
                'further_action'=>true
            ],[
                'code'=>'3',
                'title'=>'Dispatched',
                'further_action'=>true
            ],[
                'code'=>'4',
                'title'=>'In Transit',
                'further_action'=>true
            ],[
                'code'=>'5',
                'title'=>'Ready to Pick up',
                'further_action'=>false
            ],[
                'code'=>'6',
                'title'=>'Cancelled',
                'further_action'=>false
            ],[
                'code'=>'7',
                'title'=>'Delayed',
                'further_action'=>true
            ])
    );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('label_order_statuses');
    }
}
