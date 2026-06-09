<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFasilitasHarianAktivitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fasilitas_harian_aktivitas', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId('item_id')
                ->constrained('fasilitas_harian_items')
                ->cascadeOnDelete();

            $table->text('aktivitas');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fasilitas_harian_aktivitas');
    }
}
