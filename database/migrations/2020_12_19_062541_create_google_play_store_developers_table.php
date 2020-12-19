<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGooglePlayStoreDevelopersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_play_store_developers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('devId')->unique();
            $table->bigInteger('gameCount')->nullable();
            $table->string('email')->nullable();
            $table->dateTime('lastReleasedDate')->nullable();
            $table->dateTime('lastUpdatedDate')->nullable();
            $table->dateTime('lastVersionDate')->nullable();
            $table->string('url')->nullable();
            $table->string('website')->nullable();
            $table->string('cover')->nullable();
            $table->string('icon')->nullable();
            $table->text('address')->nullable();
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
        Schema::dropIfExists('google_play_store_developers');
    }
}
