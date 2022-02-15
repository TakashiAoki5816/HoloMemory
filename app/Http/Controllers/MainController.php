<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\DailyUpcomingVideos;
use App\Services\Youtube\SearchListService;
use Illuminate\View\View;

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
     * 配信予定動画一覧をviewに渡す
     *
     * @return View
     */
    public function main(): View
    {
        $videos = $this->dailyUpcomingVideos->getVideos();

        return view('main/index', ['videos' => $videos]);
    }

    /**
     * 最新の配信予定動画一覧を取得
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function request()
    {
        $members = $this->member->getAllMembers();
        $this->searchListService->requestSearchList($members);

        return redirect()->route('root');
    }
}
