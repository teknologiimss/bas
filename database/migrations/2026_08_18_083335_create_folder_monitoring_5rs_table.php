<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('folder_monitoring_5rs', function (Blueprint $table) {
            $table->id();
            $table->string('tahun');
            $table->string('nama_folder');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('folder_monitoring_5rs');
    }
};