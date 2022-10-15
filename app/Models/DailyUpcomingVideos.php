<?php

namespace App\Models;

use DateTime;
use App\Models\Member;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Consts\DailyUpcomingVideosConsts;

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
     * @param string $group
     * @return Collection $grouped
     */
    public function getVideos(string $group): Collection
    {
        $collection = $this->getCollectionByGroupId($group);

        $multiplied = $collection->map(function ($stream, $key) {
            $dateTime = new DateTime($stream->scheduled_start_time);
            $day = $dateTime->format("m/d") . DailyUpcomingVideosConsts::WEEK[$dateTime->format("w")];
            $stream->start_date = $day;
            return $stream;
        });
        $grouped = $multiplied->groupBy('start_date');

        return $grouped;
    }

    /**
     * 登録されている配信日付を取得
     *
     * @param string $group
     * @return array $scheduleDateList
     */
    public function getScheduleDate($group): array
    {
        $collection = $this->getCollectionByGroupId($group);
        $scheduleDates = $collection->pluck('scheduled_start_time')->all();

        $scheduleDateList = [];
        foreach ($scheduleDates as $scheduleDate) {
            $dateTime = new DateTime($scheduleDate);
            $day = $dateTime->format("m/d") . DailyUpcomingVideosConsts::WEEK[$dateTime->format("w")];

            $scheduleDateList[] = $day;
        }

        $scheduleDateList = array_unique($scheduleDateList);
        $scheduleDateList = array_values($scheduleDateList);
        return $scheduleDateList;
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
