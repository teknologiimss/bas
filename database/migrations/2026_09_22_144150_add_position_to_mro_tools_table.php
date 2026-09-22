<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mro_tools', function (Blueprint $table) {
            $table->integer('position')->default(0)->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('mro_tools', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
};