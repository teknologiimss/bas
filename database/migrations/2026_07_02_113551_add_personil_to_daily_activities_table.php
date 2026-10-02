<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('daily_activities', 'personil')) {
            Schema::table('daily_activities', function (Blueprint $table) {
                $table->json('personil')->after('keterangan');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('daily_activities', 'personil')) {
            Schema::table('daily_activities', function (Blueprint $table) {
                $table->dropColumn('personil');
            });
        }
    }
};