<?php

// database/migrations/xxxx_xx_xx_create_pekerjaan_wilayah1_tables.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pekerjaan_wilayah1s', function (Blueprint $table) {
            $table->id();
            $table->string('nama_proyek');
            $table->string('no_kontrak')->nullable();
            $table->date('tanggal_kontrak')->nullable();
            $table->date('tanggal_selesai_kontrak')->nullable();
            $table->timestamps();
        });

        Schema::create('pekerjaan_wilayah1_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pekerjaan_wilayah1_id')->constrained('pekerjaan_wilayah1s')->onDelete('cascade');
            $table->string('item_pekerjaan');
            $table->string('satuan');
            $table->decimal('vol_rencana', 15, 2);
            $table->decimal('harga_satuan', 15, 2)->nullable();
            $table->decimal('progress_utama', 5, 2)->default(0);
            $table->json('progress_mingguan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pekerjaan_wilayah1_items');
        Schema::dropIfExists('pekerjaan_wilayah1s');
    }
};
