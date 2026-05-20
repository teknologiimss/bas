<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUserIdFromCutiTable extends Migration
{
    public function up()
    {
        Schema::table('cuti', function (Blueprint $table) {

            // hapus foreign key
            $table->dropForeign(['user_id']);

            // hapus kolom
            $table->dropColumn('user_id');
        });
    }

    public function down()
    {
        Schema::table('cuti', function (Blueprint $table) {

            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }
}
