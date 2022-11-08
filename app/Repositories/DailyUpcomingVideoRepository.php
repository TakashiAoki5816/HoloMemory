<?php

namespace App\Repositories;

use App\Consts\DailyUpcomingVideosConsts;
use App\Models\DailyUpcomingVideos;
use DateTime;
use Illuminate\Database\Eloquent\Collection;

class DailyUpcomingVideoRepository
{
    /**
     * @param DailyUpcomingVideos $dailyUpcomingVideoModel
     */
    public function __construct(DailyUpcomingVideos $dailyUpcomingVideoModel)
    {
        $this->dailyUpcomingVideoModel = $dailyUpcomingVideoModel;
    }

    /**
     * 登録されている配信予定動画を全て取得
     *
     * @param string $group
     * @return Collection $grouped
     */
    public function fetchAllVideos(array $request): Collection
    {
        $collection = $this->dailyUpcomingVideoModel->getCollectionByGroupId($request['group']);

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
        $collection = $this->dailyUpcomingVideoModel->getCollectionByGroupId($group);
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
}
