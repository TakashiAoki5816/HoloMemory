<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\DailyUpcomingVideos;
use Illuminate\Http\RedirectResponse;
use App\Services\Youtube\SearchListService;

class YoutubeController extends Controller
{
    protected $member;
    protected $searchListService;

    /**
     * @param SearchListService $searchListService
     */
    public function __construct(SearchListService $searchListService, DailyUpcomingVideos $dailyUpcomingVideos)
    {
        $this->searchListService = $searchListService;
        $this->dailyUpcomingVideos = $dailyUpcomingVideos;
    }

    /**
     * 配信情報一覧取得
     *
     * @return void
     */
    public function index()
    {
        $videos = $this->dailyUpcomingVideos->getVideos();

        return response()->json($videos);
    }

    /** */
    // public function getVideos(): RedirectResponse
    // {
    //     $members = $this->member->getAllMembers();

    //     return redirect()->route('root');
    // }

    /**
     * 最新の配信予定動画一覧を取得
     *
     * @return RedirectResponse
     */
    public function store()
    {
        $this->searchListService->requestSearchList();
        $videos = $this->dailyUpcomingVideos->getVideos();

        return response()->json($videos);
    }

    # 投稿表示
    public function show(Int $id)
    {
        $post = Post::find($id);
        return response()->json($post);
    }


    # 投稿編集
    public function update(Int $id, Request $request)
    {
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->updated_at = now();
        $post->save();
        return response()->json($post);
    }

    # 投稿削除
    public function delete(Int $id)
    {
        $post = Post::find($id)->delete();
        return response()->json(Post::all());
    }
}
