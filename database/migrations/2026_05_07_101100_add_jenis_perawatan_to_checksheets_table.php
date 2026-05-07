<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('checksheets', function (Blueprint $table) {

            $table->string('jenis_perawatan')
                ->nullable()
                ->after('tanggal');

        });
    }

    public function down(): void
    {
        Schema::table('checksheets', function (Blueprint $table) {

            $table->dropColumn('jenis_perawatan');

        });
    }
};