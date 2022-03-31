<?php

namespace App\Models;

use App\Models\Member;
use App\Consts\DailyUpcomingVideosConsts;
use DateTime;
use Illuminate\Database\Eloquent\Model;

class DailyUpcomingVideos extends Model
{
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
     * @return object Collection
     */
    public function getVideos(): object
    {
        return $this->with('member')->orderBy('scheduled_start_time', 'asc')->get();
    }

    /**
     * 日本グループの配信動画を取得
     *
     * @return object Collection
     */
    public function getJpVideos(): object
    {
        return $this->with('member')->where('country', 'JP')->orderBy('scheduled_start_time', 'asc')->get();
    }

    /**
     * 英語グループの配信動画を取得
     *
     * @return object Collection
     */
    public function getEnVideos(): object
    {
        return $this->with('member')->where('country', 'EN')->orderBy('scheduled_start_time', 'asc')->get();
    }

    /**
     * インドネシアグループの配信動画を取得
     *
     * @return object Collection
     */
    public function getIdVideos(): object
    {
        return $this->with('member')->where('country', 'ID')->orderBy('scheduled_start_time', 'asc')->get();
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
