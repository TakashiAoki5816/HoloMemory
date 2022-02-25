<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Services\Youtube\SearchListService;
use Illuminate\Http\RedirectResponse;

class YoutubeController extends Controller
{
    protected $member;
    protected $searchListService;

    /**
     * @param Member $member
     * @param SearchListService $searchListService
     */
    public function __construct(Member $member, SearchListService $searchListService)
    {
        $this->member = $member;
        $this->searchListService = $searchListService;
    }

    /**
     * 最新の配信予定動画一覧を取得
     *
     * @return RedirectResponse
     */
    public function request(): RedirectResponse
    {
        $members = $this->member->getAllMembers();
        $this->searchListService->requestSearchList($members);

        return redirect()->route('root');
    }
}
