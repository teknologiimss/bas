<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPoluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_poluar', function (Blueprint $table) {
            $table->id();
            $table->integer('id_poluar');
            $table->integer('id_del_poluar');
            $table->integer('id_pr');
            $table->integer('id_detail_pr');
            $table->integer('poluar_qty');
            $table->date('batas_akhir')->nullable();
            $table->string('harga')->nullable();
            $table->string('mata_uang')->nullable();
            $table->string('vat')->nullable();
            $table->integer('is_accept');
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
        Schema::dropIfExists('detail_poluar');
    }
}
