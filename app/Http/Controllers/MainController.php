<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\DailyUpcomingVideos;
use App\Services\Youtube\SearchListService;

class MainController extends Controller
{
    protected $searchListService;
    protected $dailyUpcomingVideos;

    /**
     * @param Member $member
     * @param SearchListService $searchListService
     * @param DailyUpcomingVideos $dailyUpcomingVideos
     */
    public function __construct(Member $member, SearchListService $searchListService, DailyUpcomingVideos $dailyUpcomingVideos)
    {
        $this->member = $member;
        $this->searchListService = $searchListService;
        $this->dailyUpcomingVideos = $dailyUpcomingVideos;
    }

    /**
     *　配信予定動画一覧を取得
     *
     * @return void
     */
    public function main()
    {
        $members = $this->member->getAllMembers();
        $this->searchListService->requestSearchList($members);
        $videos = $this->dailyUpcomingVideos->getVideos();

        //APIを叩けなかった場合はエラーメッセージを表示
        // if ($response instanceof View) {
        //     return view('main/error', ['message' => $response]);
        // }

        return view('main/index', ['videos' => $videos]);
    }

    public function index()
    {
        $videos = $this->dailyUpcomingVideos->getVideos();

        return view('main/index', ['videos' => $videos]);
    }
}
