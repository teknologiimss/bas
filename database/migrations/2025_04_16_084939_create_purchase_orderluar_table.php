<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orderluar', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id');
            $table->string('no_poluar');
            $table->integer('proyek_id');
            $table->integer('pr_id');
            $table->date('tanggal_poluar');
            $table->string('reference')->nullable();
            $table->string('rfq')->nullable();
            $table->string('quotation')->nullable();
            $table->string('no_nego')->nullable();
            $table->string('final_quotation')->nullable();
            $table->date('batas_poluar');
            $table->string('keterangan_nama')->nullable();

            $table->string('delivery')->nullable();
            $table->string('shipment')->nullable();
            $table->string('delivery_term')->nullable();
            $table->string('destination')->nullable();
            $table->string('payment')->nullable();
           
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
        Schema::dropIfExists('purchase_orderluar');
    }
}
