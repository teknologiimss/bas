<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengirimanDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengiriman_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('pengiriman_id');
            $table->string('trainset');
            $table->string('tipe_kereta');
            $table->string('nomor_lambung');
            $table->string('batch');
            $table->string('trucking');
            $table->string('nopol');
            $table->string('no_sjn');
            $table->string('code_armada');
            $table->date('plan_delivery');
            $table->date('actual_delivery');
            $table->string('leadtime_delivery');
            $table->string('status_delivery');
            $table->date('loading_truck');
            $table->date('loading_vessel');
            $table->date('plan_unloading');
            $table->date('actual_unloading');
            $table->string('leadtime_unloading');
            
            $table->string('vendor');
            $table->string('keterangan');
           
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
        Schema::dropIfExists('pengiriman_detail');
    }
}
