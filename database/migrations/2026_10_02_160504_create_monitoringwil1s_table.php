<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('monitoringwil1s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_id')->constrained('proyek_wil1s')->onDelete('cascade');
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

        Schema::create('monitoringwil1_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monitoringwil1_id')->constrained('monitoringwil1s')->onDelete('cascade');
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
        Schema::dropIfExists('monitoringwil1_documents');
        Schema::dropIfExists('monitoringwil1s');
    }
};
