<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('monitoringwil1_documents', function (Blueprint $table) {
            $table->string('jenis_dokumen')->nullable()->after('nama_dokumen');
            $table->decimal('harga', 15, 2)->nullable()->after('jenis_dokumen');
            $table->enum('kriteria', ['Rencana', 'Realisasi'])->nullable()->after('harga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monitoringwil1_documents', function (Blueprint $table) {
            $table->dropColumn(['jenis_dokumen', 'harga', 'kriteria']);
        });
    }
};
