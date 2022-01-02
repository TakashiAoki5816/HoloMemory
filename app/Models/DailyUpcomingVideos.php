<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyUpcomingVideos extends Model
{
    protected $table = 'daily_upcoming_videos';

    /**
     * 登録されている配信予定動画一覧を全て取得
     *
     * @return void
     */
    public function getVideos()
    {
        return DailyUpcomingVideos::all();
    }
}
