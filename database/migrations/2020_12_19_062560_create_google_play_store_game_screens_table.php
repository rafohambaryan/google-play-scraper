<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGooglePlayStoreGameScreensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_play_store_game_screens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('game_id')->index();
            $table->string('hashUrl')->nullable();
            $table->string('size')->nullable();
            $table->longText('url')->nullable();
            $table->foreign('game_id')->references('id')->on('google_play_store_games')->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::dropIfExists('google_play_store_game_screens');
    }
}
