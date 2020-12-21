<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGooglePlayStoreGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_play_store_games', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('developer_id')->index();
            $table->unsignedBigInteger('category_id')->index();
            $table->string('packagesName')->unique();
            $table->string('androidVersion')->nullable();
            $table->string('appVersion')->nullable();
            $table->string('categoryName')->nullable();
            $table->string('contentRating')->nullable();
            $table->string('country')->nullable();
            $table->longText('description')->nullable();
            $table->longText('fullUrl')->nullable();
            $table->string('installs')->nullable();
            $table->longText('videoUrl')->nullable();
            $table->longText('videoImgUrl')->nullable();
            $table->string('videoId')->nullable();
            $table->dateTime('releaseDate')->nullable();
            $table->dateTime('updatedDate')->nullable();
            $table->dateTime('oldUpdatedDate')->nullable();
            $table->dateTime('versionDate')->nullable();
            $table->dateTime('oldVersionDate')->nullable();
            $table->string('score')->nullable();
            $table->string('size')->nullable();
            $table->string('minAndroidVersion')->nullable();
            $table->string('icon')->nullable();
            $table->integer('numberReviews')->nullable();
            $table->integer('numberVoters')->nullable();
            $table->integer('versionCount')->nullable();
            $table->string('oldVersion')->nullable();
            $table->boolean('isAutoTranslatedDescription')->default(true);
            $table->boolean('isContainsAds')->default(true);
            $table->boolean('isContainsIAP')->default(true);
            $table->boolean('isEditorsChoice')->default(true);
            $table->boolean('inactive')->default(false);
            $table->boolean('isFree')->default(true);
            $table->string('locale')->nullable();
            $table->longText('privacyPoliceUrl')->nullable();
            $table->longText('url')->nullable();
            $table->text('priceText')->nullable();
            $table->float('price')->nullable();
            $table->foreign('developer_id')->references('id')->on('google_play_store_developers')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('category_id')->references('id')->on('google_play_store_categories')->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::dropIfExists('google_play_store_games');
    }
}
