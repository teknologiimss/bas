<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kasbon_folders', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('po_nota_dinas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kasbon_folders');
    }
};
