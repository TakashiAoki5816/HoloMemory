<?php

namespace App\Http\Controllers;

use App\Models\DailyUpcomingVideos;
use App\Services\Youtube\SearchListService;

class MainController extends Controller
{
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
     *　daily_upcoming_videosに格納した配信予定動画一覧を取得し、viewに渡す
     *
     * @return void
     */
    public function main()
    {
        $this->searchListService->requestSearchList();
        $videos = $this->dailyUpcomingVideos->getVideos();

        //APIを叩けなかった場合はエラーメッセージを表示
        // if ($response instanceof View) {
        //     return view('main/error', ['message' => $response]);
        // }

        return view('main/index', ['videos' => $videos]);
    }
}
