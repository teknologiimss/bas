<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecksheetItemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checksheet_item_details', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('item_id')
                ->constrained('checksheet_items')
                ->cascadeOnDelete();

            $table->text('aktivitas')->nullable();

            $table->text('standar')->nullable();

            $table->integer('urutan')->default(0);
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
        Schema::dropIfExists('checksheet_item_details');
    }
}
