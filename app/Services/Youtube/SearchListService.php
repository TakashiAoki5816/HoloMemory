<?php

namespace App\Services\Youtube;

use App\Models\Member;
use App\Repositories\Guzzle\GuzzleRepositoryInterface;
use App\Services\Youtube\VideosListService;
use GuzzleHttp\Exception\RequestException;

class SearchListService
{
    protected $clientInterface;

    /**
     * @param GuzzleRepositoryInterface $clientInterface
     */
    public function __construct(Member $member, GuzzleRepositoryInterface $clientInterface, VideosListService $videosListService)
    {
        $this->member = $member;
        $this->clientInterface = $clientInterface;
        $this->videosListService = $videosListService;
    }

    /**
     * Youtube Data API Search_Listを叩く
     *
     * @return void
     */
    public function requestSearchList()
    {
        $method = "GET";
        $videos = array();

        $members = $this->member->getAllMembers();
        foreach ($members as $member) {
            $channel_id = $member->channel_id;
            $url = "https://www.googleapis.com/youtube/v3/search?key=" . config('app.API_KEY') . "&channel_id=" . $channel_id . "&part=snippet&eventType=upcoming&type=video";

            $response = $this->clientInterface->firstRequest($method, $url);

            if ($response instanceof RequestException) {
                //メインのAPIキーが使えなかった場合、別プロジェクトのAPIキーを使用
                $url = $this->subSetUrl($channel_id);
                $response = $this->clientInterface->secondRequest($method, $url);
            }

            $body = $response->getBody();
            $video = json_decode($body, true);

            $this->storageVideoInfo($video);
            $videos = $this->storageVideos($videos, $video);
            if ($member->id == 2) {
                dd($videos);
            }
        }
        dd($videos);
        $this->storeDailyUpcomingVideos($videos);
    }

    /**
     * サブAPIキーを使用
     *
     * @param string $channel_id
     * @return string
     */
    public function subSetUrl($channel_id)
    {
        return "https://www.googleapis.com/youtube/v3/search?key=" . config('app.SUB_API_KEY') . "&channel_id=" . $channel_id . "&part=snippet&eventType=upcoming&type=video";
    }

    public function storageVideoInfo($video)
    {
        $videoInfo = array();

        $videoId = $video["items"][0]["id"]["videoId"];
        $channelId = $video["items"][0]["snippet"]["channelId"];
        $title = $video["items"][0]["snippet"]["title"];
        $thumbnails = $video["items"][0]["snippet"]["thumbnails"]["medium"]["url"];
        $this->videosListService->getScheduledStartTime($channelId);


        $bb = array_push($videoInfo, $video["regionCode"]);
        // dd($video["regionCode"]);
    }

    /**
     * Undocumented function
     *
     * @param array $videos
     * @param array $video
     * @return array
     */
    public function storageVideos($videos, $video)
    {
        // array_push($videos)
        return array_merge($videos, $video);
    }

    public function storeDailyUpcomingVideos($videos)
    {
        dd($videos);
        dd($videos['items'][0]);
        // DB::table('daily_upcoming_videos')->insert([
        //     ['video_id' => $video['items']]
        // ])
    }
}
