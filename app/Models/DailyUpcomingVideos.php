<?php

namespace App\Models;

use App\Models\Member;
use DateTime;
use Illuminate\Database\Eloquent\Model;

class DailyUpcomingVideos extends Model
{
    protected $table = 'daily_upcoming_videos';

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
        return $this->with('member')->get();
    }

    public function getStartTimeAttribute()
    {
        $startTime = new DateTime($this->scheduled_start_time);
        return $startTime->format("H:i");
    }
}
