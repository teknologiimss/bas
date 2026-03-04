<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRevisiToBpmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::table('bpm', function (Blueprint $table) {
            $table->integer('revisi')->nullable()->default(null)->after('tgl_bpm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bpm', function (Blueprint $table) {
            $table->dropColumn('revisi');
        });
    }
}
