<?php

namespace App\Services\Youtube;

use App\Models\Member;
use App\Services\Guzzle\GuzzleService;

class SearchListService implements SearchServiceInterface
{
    public function __construct(Member $member, GuzzleService $guzzleService) {
        $this->member = $member;
        $this->guzzleService = $guzzleService;
    }

    public function requestSearchList() {
        $client = new Client();
        $method = "GET";
        $videos = array();

        $members = $this->member->getAllMembers();
        foreach ($members as $member) {
            $channel_id = $member->channel_id;
            $url = "https://www.googleapis.com/youtube/v3/search?key=" . config('app.API_KEY') . "&channel_id=" . $channel_id . "&part=snippet&eventType=upcoming&type=video";

            $response = $this->guzzleService->requestGuzzle($client, $method, $url);
            if (!$response instanceof Response) {
                //メインのAPIキーが使えなかった場合、別プロジェクトのAPIキーを使用
                $url = "https://www.googleapis.com/youtube/v3/search?key=" . config('app.SUB_API_KEY') . "&channel_id=" . $channel_id . "&part=snippet&eventType=upcoming&type=video";
                $response = $this->guzzleService->requestGuzzle($client, $method, $url);

                //もう一つのAPIキーも使用できない場合
                if (!$response instanceof Response) {
                    return $response;
                }
            }

            $body = $response->getBody();
            $this->storageVideos($videos, $body);
        }

        $this->storeDailyUpcomingVideos($videos);
    }

    public function storeDailyUpcomingVideos($videos) {
        dd($videos);
        dd($videos['items'][0]);
        // DB::table('daily_upcoming_videos')->insert([
        //     ['video_id' => $video['items']]
        // ])
    }
}
