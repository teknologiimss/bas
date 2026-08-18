<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lampiran_5rs', function (Blueprint $table) {
            // Tambahkan kolom jenis_lampiran ('absensi' atau 'pelaporan')
            $table->string('jenis_lampiran')->default('pelaporan')->after('checksheet_5r_id');
        });
    }

    public function down(): void
    {
        Schema::table('lampiran_5rs', function (Blueprint $table) {
            $table->dropColumn('jenis_lampiran');
        });
    }
};