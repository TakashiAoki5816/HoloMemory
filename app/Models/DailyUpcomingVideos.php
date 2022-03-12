<?php

namespace App\Models;

use App\Models\Member;
use App\Consts\DailyUpcomingVideosConsts;
use DateTime;
use Illuminate\Database\Eloquent\Model;

class DailyUpcomingVideos extends Model
{
    protected $table = 'daily_upcoming_videos';
    protected $appends = [
        'start_date',
        'start_time',
    ];

    /**
     * memberのリレーション取得
     *
     * @return object Member
     */
    public function member(): object
    {
        return $this->belongsTo(Member::class, 'channel_id', 'channel_id');
    }

    /**
     * 登録されている配信予定動画を全て取得
     *
     * @return object DailyUpcomingVideos
     */
    public function getVideos(): object
    {
        return $this->with('member')->orderBy('scheduled_start_time', 'asc')->get();
    }

    /**
     * 日付を取得
     *
     * @return string
     */
    public function getStartDateAttribute(): string
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
    public function getStartTimeAttribute(): string
    {
        $dateTime = new DateTime($this->scheduled_start_time);

        return $dateTime->format("H:i");
    }
}
