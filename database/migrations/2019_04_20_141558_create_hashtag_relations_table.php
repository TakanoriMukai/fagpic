<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHashtagRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hashtag_relations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('tweet_id');
            $table->unsignedInteger('hashtag_id');
            $table->timestamps();

            $table->foreign('tweet_id')->references('id')->on('tweets');
            $table->foreign('hashtag_id')->references('id')->on('twitter_hashtags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hashtag_relations');
    }
}
