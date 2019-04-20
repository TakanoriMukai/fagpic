<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTweetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tweets', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('user_id');
            $table->text('tweet');
            $table->timestamp('posted_at');
            $table->unsignedInteger('retweet_count');
            $table->unsignedInteger('favorite_count');
            $table->string('tweet_url');
            $table->timestamps();

            $table->primary('id');
            $table->foreign('user_id')->references('id')->on('twitter_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tweets');
    }
}
