<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('memos', function (Blueprint $table) {
            // Menambahkan kolom setelah penutup atau field terkait lainnya
            $table->string('ttd_path')->nullable()->after('nama_penandatangan');
            $table->string('judul_lampiran')->nullable()->after('ttd_path');
            $table->string('lampiran_path')->nullable()->after('judul_lampiran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('memos', function (Blueprint $table) {
            $table->dropColumn(['ttd_path', 'judul_lampiran', 'lampiran_path']);
        });
    }
};