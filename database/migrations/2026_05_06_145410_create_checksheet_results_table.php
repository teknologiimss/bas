<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecksheetResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checksheet_results', function (Blueprint $table) {
            $table->id();
            
            // Menggunakan foreignId bawaan Laravel (lebih ringkas)
            $table->foreignId('item_id')
                  ->constrained('checksheet_items')
                  ->onDelete('cascade');

            // Tambahkan kolom lain di sini jika ada, contoh:
            // $table->string('result')->nullable();
            // $table->text('notes')->nullable();

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
        Schema::dropIfExists('checksheet_results');
    }
}