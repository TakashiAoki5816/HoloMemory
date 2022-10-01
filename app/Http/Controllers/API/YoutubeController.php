<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
     * @return object Collection
     */
    public function index(): object
    {
        return $this->dailyUpcomingVideos->getVideos();
    }

    /**
     * JPの配信情報を取得
     *
     * @return object Collection
     */
    public function jp(): object
    {
        return $this->dailyUpcomingVideos->getJpVideos();
    }

    /**
     * ENの配信情報を取得
     *
     * @return object Collection
     */
    public function en(): object
    {
        return $this->dailyUpcomingVideos->getEnVideos();
    }

    /**
     * IDの配信情報を取得
     *
     * @return object Collection
     */
    public function id(): object
    {
        return $this->dailyUpcomingVideos->getIdVideos();
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
