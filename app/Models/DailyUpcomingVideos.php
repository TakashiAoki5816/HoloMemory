<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyUpcomingVideos extends Model
{
    protected $table = 'daily_upcoming_videos';

    public function getVideos()
    {
        return DailyUpcomingVideos::all();
    }
}
