<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_activity_attachments', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('daily_activity_id');

            $table->string('file');

            $table->timestamps();

            $table->foreign('daily_activity_id')
                ->references('id')
                ->on('daily_activities')
                ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_activity_attachments');
    }
};
