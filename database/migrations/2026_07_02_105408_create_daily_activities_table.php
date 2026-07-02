<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('daily_activities', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('monitoring_id');

            $table->text('kegiatan');

            $table->enum('status', ['Open', 'Closed'])->default('Open');

            $table->date('tanggal');

            $table->text('keterangan')->nullable();

            // Menyimpan banyak nama personil dalam bentuk JSON
            $table->json('personil');

            $table->timestamps();

            $table
                ->foreign('monitoring_id')
                ->references('id')
                ->on('monitorings')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_activities');
    }
};
