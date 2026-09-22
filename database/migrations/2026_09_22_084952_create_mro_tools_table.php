<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mro_tools', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tools');
            $table->text('spesifikasi')->nullable();
            $table->integer('qty')->default(0);
            $table->string('satuan')->default('unit');
            $table->enum('kondisi', ['Baik', 'Rusak', 'Scrap'])->default('Baik');
            $table->text('keterangan')->nullable();
            $table->string('jenis')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mro_tools');
    }
};
