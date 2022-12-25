<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->integer('podcast_id');
            $table->id();
            $table->integer('no');
            $table->string('title');
            $table->string('path');
            $table->foreign('podcast_id')->references('id')->on('podcasts')->onUpdate('cascade')->onDelete('cascade');
            $table->unique(["id", "podcast_id"]);
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
        Schema::dropIfExists('episodes');
    }
};