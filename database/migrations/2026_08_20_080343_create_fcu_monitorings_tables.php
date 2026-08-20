<?php

// database/migrations/xxxx_xx_xx_create_fcu_monitorings_tables.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Utama Monitoring FCU
        Schema::create('fcu_monitorings', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->enum('jenis_perawatan', ['P1', 'P3', 'P6', 'P12', 'Unscheduled']);
            $table->date('tanggal');
            $table->string('no_fcu');
            $table->enum('kesimpulan', ['SO', 'SO DENGAN CATATAN', 'TSO'])->nullable();
            $table->timestamps();
        });

        // Form Tambahan jika Unscheduled
        Schema::create('fcu_unscheduled_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fcu_monitoring_id')->constrained('fcu_monitorings')->onDelete('cascade');
            $table->date('tanggal');
            $table->text('jenis_kerusakan');
            $table->text('tindak_lanjut');
            $table->enum('status', ['OK', 'NOK']);
            $table->string('personil');
            $table->timestamps();
        });

        // Section / Sub-Judul FCU
        Schema::create('fcu_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fcu_monitoring_id')->constrained('fcu_monitorings')->onDelete('cascade');
            $table->string('kode')->nullable();
            $table->string('nama_section');
            $table->timestamps();
        });

        // Item Pekerjaan
        Schema::create('fcu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fcu_section_id')->constrained('fcu_sections')->onDelete('cascade');
            $table->string('nomor')->nullable();
            $table->text('uraian');
            $table->timestamps();
        });

        // Detail Aktivitas & Standar
        Schema::create('fcu_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fcu_item_id')->constrained('fcu_items')->onDelete('cascade');
            $table->text('aktivitas')->nullable();
            $table->text('standar')->nullable();
            $table->timestamps();
        });

        // Hasil Isian dari Mobile Blade
        Schema::create('fcu_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fcu_detail_id')->constrained('fcu_details')->onDelete('cascade');
            $table->enum('status', ['OK', 'NOK'])->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // Foto Hasil Mobile Checksheet
        Schema::create('fcu_result_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fcu_result_id')->constrained('fcu_results')->onDelete('cascade');
            $table->string('foto');
            $table->timestamps();
        });

        // Catatan
        Schema::create('fcu_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fcu_monitoring_id')->constrained('fcu_monitorings')->onDelete('cascade');
            $table->text('catatan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fcu_notes');
        Schema::dropIfExists('fcu_result_photos');
        Schema::dropIfExists('fcu_results');
        Schema::dropIfExists('fcu_details');
        Schema::dropIfExists('fcu_items');
        Schema::dropIfExists('fcu_sections');
        Schema::dropIfExists('fcu_unscheduled_forms');
        Schema::dropIfExists('fcu_monitorings');
    }
};
