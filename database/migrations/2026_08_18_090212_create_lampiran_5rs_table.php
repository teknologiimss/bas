<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lampiran_5rs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checksheet_5r_id')->constrained('checksheet_5rs')->onDelete('cascade');
            $table->string('file');
            $table->string('nama_file');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lampiran_5rs');
    }
};