<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IdRequiredDailyUpcomingVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_upcoming_videos', function (Blueprint $table) {
            $table->dropColumn('id');
            DB::statement("ALTER TABLE daily_upcoming_videos MODIFY COLUMN channel_id varchar(255) NOT NULL FIRST");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_upcoming_videos', function (Blueprint $table) {
            $table->increments('id')->first();
            DB::statement("ALTER TABLE daily_upcoming_videos MODIFY COLUMN channel_id varchar(255) NOT NULL AFTER video_id");
        });
    }
}
