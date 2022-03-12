<?php

namespace App\Http\Controllers;

use App\Models\DailyUpcomingVideos;
use App\Services\Youtube\SearchListService;

class YoutubeController extends Controller
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
     * @return Array
     */
    public function index()
    {
        $videos = $this->dailyUpcomingVideos->getVideos();

        return $videos;
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
