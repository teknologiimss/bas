<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFcu2ToFcuMonitoringsTable extends Migration
{
    public function up(): void
    {
        Schema::table('fcu_monitorings', function (Blueprint $table) {
            $table->string('no_fcu_2')->nullable()->after('no_fcu');
            $table->date('tanggal_2')->nullable()->after('tanggal');
        });
    }

    public function down(): void
    {
        Schema::table('fcu_monitorings', function (Blueprint $table) {
            $table->dropColumn(['no_fcu_2', 'tanggal_2']);
        });
    }
}
