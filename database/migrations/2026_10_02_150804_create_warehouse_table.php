<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('warehouse', function (Blueprint $table) {
            $table->id('warehouse_id'); // Primary key bigint AUTO_INCREMENT
            $table->string('warehouse_name', 255); // varchar(255) NOT NULL
            $table->timestamps(); // opsional: tambahkan jika butuh created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse');
    }
};