<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DailyUpcomingVideos;
use App\Services\Youtube\SearchListService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class StreamsController extends Controller
{
    protected $member;
    protected $searchListService;

    /**
     * @param SearchListService $searchListService
     * @param DailyUpcomingVideos $dailyUpcomingVideos
     */
    public function __construct(SearchListService $searchListService, DailyUpcomingVideos $dailyUpcomingVideos)
    {
        $this->searchListService = $searchListService;
        $this->dailyUpcomingVideos = $dailyUpcomingVideos;
    }

    /**
     * 配信情報一覧取得
     *
     * @return Collection
     */
    public function index(Request $request): Collection
    {
        $group = $request->query('group');
        return $this->dailyUpcomingVideos->getVideos($group);
    }

    /**
     * 配信情報一覧取得
     *
     * @return array
     */
    public function date_index(Request $request): array
    {
        $group = $request->query('group');
        return $this->dailyUpcomingVideos->getScheduleDate($group);
    }

    /**
     * 最新の配信予定動画一覧をdaily_upcoming_videosに格納
     *
     * @return void
     */
    public function store()
    {
        $params = $this->searchListService->requestSearchList();
        $this->searchListService->insertDailyUpcomingVideos($params);
    }
}
