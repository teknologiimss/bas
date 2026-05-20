<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuti_tahunans', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id');

            $table->year('tahun');

            // jatah awal
            $table->integer('jatah')
                ->default(8);

            // sisa tahun lalu
            $table->integer('carry_over')
                ->default(0);

            // bonus tambahan
            $table->integer('tambahan')
                ->default(0);

            // pengurangan manual
            $table->integer('pengurangan')
                ->default(0);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuti_tahunans');
    }
};
