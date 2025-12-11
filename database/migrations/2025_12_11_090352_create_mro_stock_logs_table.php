<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMroStockLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mro_stock_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mro_id');
            $table->string('barcode');
            $table->string('type');  // IN or OUT
            $table->integer('qty');
            $table->integer('stock_before');
            $table->integer('stock_after');
            $table->integer('proyek');
            $table->string('user')->nullable();  // nama yg input
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
        Schema::dropIfExists('mro_stock_logs');
    }
}
