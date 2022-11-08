<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\DailyUpcomingVideoRepository;
use App\Services\Youtube\SearchListService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class StreamsController extends Controller
{
    protected $member;
    protected $searchListService;

    /**
     * @param SearchListService $searchListService
     * @param DailyUpcomingVideoRepository $dailyUpcomingVideoRepository
     */
    public function __construct(SearchListService $searchListService, DailyUpcomingVideoRepository $dailyUpcomingVideoRepository)
    {
        $this->searchListService = $searchListService;
        $this->dailyUpcomingVideoRepository = $dailyUpcomingVideoRepository;
    }

    /**
     * 配信情報一覧取得
     *
     * @return Collection
     */
    public function index(Request $request): Collection
    {
        $request = $request->only([
            'group'
        ]);
        return $this->dailyUpcomingVideoRepository->fetchAllVideos($request);
    }

    /**
     * 配信日付一覧取得
     *
     * @return array
     */
    public function date_index(Request $request): array
    {
        $group = $request->query('group');
        return $this->dailyUpcomingVideoRepository->getScheduleDate($group);
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

        return response()->json([
            'status' => 200
        ]);
    }
}
