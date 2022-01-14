<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyUpcomingVideos extends Model
{
    protected $table = 'daily_upcoming_videos';

    /**
     * 登録されている配信予定動画を全て取得
     *
     * @return DailyUpcomingVideos
     */
    public function getVideos()
    {
        return DailyUpcomingVideos::all();
    }
}
