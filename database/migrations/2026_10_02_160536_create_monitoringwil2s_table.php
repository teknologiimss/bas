<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('monitoringwil2s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_id')->constrained('proyek_wil2s')->onDelete('cascade');
            $table->string('po_nota_dinas');
            $table->string('nama_pekerjaan');
            $table->string('jenis_pekerjaan');
            $table->date('tanggal_kontrak');
            $table->date('tanggal_selesai_kontrak');
            $table->enum('status', ['Open', 'Closed', 'On Hold'])->default('Open');
            $table->text('keterangan')->nullable();
            $table->integer('progress')->default(0);
            $table->text('keterangan2')->nullable();
            $table->timestamps();
        });

        Schema::create('monitoringwil2_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monitoringwil2_id')->constrained('monitoringwil2s')->onDelete('cascade');
            $table->integer('position')->default(0);
            $table->string('nama_dokumen');
            $table->string('file_path');
            $table->string('status')->nullable();
            $table->date('tanggal_closed')->nullable();
            $table->text('keterangan_closed')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitoringwil2_documents');
        Schema::dropIfExists('monitoringwil2s');
    }
};
