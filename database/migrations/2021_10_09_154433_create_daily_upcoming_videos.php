<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyUpcomingVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_upcoming_videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country', '2');
            $table->string('video_id', 255);
            $table->string('channel_id', 255)->comment('チャンネルID、各チャンネルページのchannel/以降の文字列');
            $table->string('title', 255);
            $table->string('thumbnails_url', 255);
            $table->dateTime('scheduled_start_time');
            $table->timestamps();

            $table->foreign('channel_id')->references('channel_id')->on('HOLOLIVE_MEMBER_MST');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_upcoming_videos');
    }
}
