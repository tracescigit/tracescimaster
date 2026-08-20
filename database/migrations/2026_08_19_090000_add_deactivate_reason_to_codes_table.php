<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeactivateReasonToCodesTable extends Migration
{
    public function up()
    {
        Schema::table('codes', function (Blueprint $table) {
            if (!Schema::hasColumn('codes', 'deactivate_reason')) {
                $table->string('deactivate_reason', 200)->nullable()->after('seized_by');
            }

            if (!Schema::hasColumn('codes', 'deactivated_at')) {
                $table->timestamp('deactivated_at')->nullable()->after('deactivate_reason');
            }

            if (!Schema::hasColumn('codes', 'deactivated_by')) {
                $table->integer('deactivated_by')->unsigned()->nullable()->after('deactivated_at');
            }
        });
    }

    public function down()
    {
        Schema::table('codes', function (Blueprint $table) {
            foreach (['deactivate_reason', 'deactivated_at', 'deactivated_by'] as $column) {
                if (Schema::hasColumn('codes', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}
