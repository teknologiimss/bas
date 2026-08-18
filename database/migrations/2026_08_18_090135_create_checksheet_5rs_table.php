<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checksheet_5rs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monitoring_5r_id')->constrained('monitoring_5rs')->onDelete('cascade');
            $table->integer('bulan'); // 1 s/d 12
            $table->string('status')->nullable(); // OK / NOK
            $table->date('tanggal')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checksheet_5rs');
    }
};