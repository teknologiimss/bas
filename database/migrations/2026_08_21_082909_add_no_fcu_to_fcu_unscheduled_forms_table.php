<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fcu_unscheduled_forms', function (Blueprint $table) {
            if (!Schema::hasColumn('fcu_unscheduled_forms', 'no_fcu')) {
                $table->string('no_fcu')->nullable()->after('fcu_monitoring_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('fcu_unscheduled_forms', function (Blueprint $table) {
            $table->dropColumn('no_fcu');
        });
    }
};