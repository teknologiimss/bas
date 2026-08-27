<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabel Utama Checksheet Pompa
        Schema::create('pompas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('jenis_perawatan');  // P1, P3, P6, P12, Unscheduled
            $table->string('no_form_unscheduled')->nullable();
            $table->string('no_pompa')->nullable();
            $table->string('no_aset')->nullable();
            $table->string('lokasi')->nullable();
            $table->date('tanggal_pelaksanaan')->nullable();
            $table->string('durasi_pekerjaan')->nullable();
            $table->string('personil')->nullable();
            $table->string('status_kondisi')->nullable();  // Khusus Unscheduled
            $table->text('jenis_kerusakan')->nullable();  // Khusus Unscheduled
            $table->text('tindak_lanjut')->nullable();  // Khusus Unscheduled
            $table->string('kesimpulan')->nullable();  // SO, SO DENGAN CATATAN, TSO
            $table->text('catatan')->nullable();
            $table->string('dokumen')->nullable();
            $table->timestamps();
        });

        // Tabel Detail Item Pekerjaan Pompa
        Schema::create('pompa_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pompa_id')->constrained('pompas')->onDelete('cascade');
            $table->string('nomor')->nullable();
            $table->string('uraian_pekerjaan');
            $table->string('aktivitas_pekerjaan')->nullable();
            $table->string('standar')->nullable();
            $table->string('status')->nullable();  // OK / NOK
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // Tabel Foto Inspeksi Pompa
        Schema::create('pompa_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pompa_item_id')->constrained('pompa_items')->onDelete('cascade');
            $table->string('foto');
            $table->string('alamat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pompa_photos');
        Schema::dropIfExists('pompa_items');
        Schema::dropIfExists('pompas');
    }
};
