<?php

namespace App\Models;

use App\Consts\DailyUpcomingVideosConsts;
use App\Models\Member;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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
     * グループIDに応じたCollectionを取得
     *
     * @param string $group
     * @return Collection
     */
    public function getCollectionByGroupId($group): Collection
    {
        if ($group === 'ALL') {
            $collection = $this->with('member')->orderBy('scheduled_start_time', 'asc')->get();
            return $collection;
        }

        $collection = $this->with('member')->where('country', $group)->orderBy('scheduled_start_time', 'asc')->get();

        return $collection;
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
