<?php

namespace App\Models;

use App\Models\Member;
use App\Consts\DailyUpcomingVideosConsts;
use DateTime;
use Illuminate\Database\Eloquent\Model;

class DailyUpcomingVideos extends Model
{
    protected $table = 'daily_upcoming_videos';

    /**
     * memberのリレーション取得
     *
     * @return void
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'channel_id', 'channel_id');
    }

    /**
     * 登録されている配信予定動画を全て取得
     *
     * @return DailyUpcomingVideos
     */
    public function getVideos()
    {
        return $this->with('member')->orderBy('scheduled_start_time', 'asc')->get();
    }

    /**
     * 日付を取得
     *
     * @return string
     */
    public function getStartDateAttribute()
    {
        $dateTime = new DateTime($this->scheduled_start_time);
        $day = $dateTime->format("m/d") . DailyUpcomingVideosConsts::WEEK[$dateTime->format("w")];

        return $day;
    }

    /**
     * 　開始時間を取得
     *
     * @return string
     */
    public function getStartTimeAttribute()
    {
        $dateTime = new DateTime($this->scheduled_start_time);

        return $dateTime->format("H:i");
    }
}
