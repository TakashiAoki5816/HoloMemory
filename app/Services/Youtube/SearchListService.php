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
            $channelId = $member->channel_id;
            $url = $this->setUrl($channelId);

            $response = $this->clientInterface->firstRequest($method, $url);

            if ($response instanceof RequestException) {
                //メインのAPIキーが使えなかった場合、別プロジェクトのAPIキーを使用
                $url = $this->subSetUrl($channelId);
                $response = $this->clientInterface->secondRequest($method, $url);
            }

            $body = $response->getBody();
            $video = json_decode($body, true);


            if (!empty($video["items"])) {
                $videoId = $video["items"][0]["id"]["videoId"];
                $interval = $this->videosListService->checkDiffDate($videoId);

                if ($interval <= "10") {
                    $this->storageVideoInfo($video);
                    $videos = $this->storageVideos($videos, $video);
                }
            }
        }
        dd($videos);
        $this->storeDailyUpcomingVideos($videos);
    }

    public function setUrl($channelId)
    {
        return "https://www.googleapis.com/youtube/v3/search?key=" . config('app.API_KEY') . "&channel_id=" . $channelId . "&part=snippet&eventType=upcoming&type=video";
    }

    /**
     * サブAPIキーを使用
     *
     * @param string $channel_id
     * @return string
     */
    public function subSetUrl($channelId)
    {
        return "https://www.googleapis.com/youtube/v3/search?key=" . config('app.SUB_API_KEY') . "&channel_id=" . $channelId . "&part=snippet&eventType=upcoming&type=video";
    }

    public function storageVideoInfo($video)
    {
        $videoInfo = array();
        $videoId = $video["items"][0]["id"]["videoId"];
        $channelId = $video["items"][0]["snippet"]["channelId"];
        $title = $video["items"][0]["snippet"]["title"];
        $thumbnails = $video["items"][0]["snippet"]["thumbnails"]["medium"]["url"];

        $date = $this->videosListService->getScheduledStartTime($videoId);
        $scheduleStartTime = $date->format('Y-m-d');

        array_push($videoInfo, $video["regionCode"], $videoId, $channelId, $title, $thumbnails, $scheduleStartTime);
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
