<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas_harian_items', function (Blueprint $table) {

            $table->id();

            $table->foreignId('fasilitas_harian_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('nomor');

            $table->string('uraian_pekerjaan');

            $table->text('aktivitas_pekerjaan');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas_harian_items');
    }
};