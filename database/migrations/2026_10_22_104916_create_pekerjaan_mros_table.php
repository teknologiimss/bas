<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pekerjaan_mros', function (Blueprint $table) {
            $table->id();
            $table->string('nama_proyek');
            $table->string('no_kontrak')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pekerjaan_mros');
    }
};
