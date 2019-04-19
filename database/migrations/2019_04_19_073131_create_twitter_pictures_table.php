<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTwitterPicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twitter_pictures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_path');
            $table->string('file_name');
            $table->unsignedInteger('size');
            $table->unsignedBigInteger('tweet_id');
            $table->timestamps('');

            $table->foreign('tweet_id')->references('id')->on('tweets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('twitter_pictures');
    }
}
