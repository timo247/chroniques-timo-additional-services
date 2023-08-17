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
        Schema::create('episode_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('episode_id')->nullable(); // Nullable foreign key
            $table->unsignedBigInteger('tag_id')->nullable(); // Nullable foreign key
            $table->timestamps();

            $table->foreign('episode_id')->references('id')->on('episodes')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('episode_tag');
    }
};
