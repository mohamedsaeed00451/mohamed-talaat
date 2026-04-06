<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use App\Traits\ApiResponseTrait;

class PodcastController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $podcasts = Podcast::latest()->paginate(10);

        $podcasts->through(function ($podcast) {
            return [
                'id' => $podcast->id,
                'title' => $podcast->title,
                'description' => $podcast->description,
                'image_url' => $podcast->image ? asset($podcast->image) : null,
                'video_url' => $podcast->video_url,
                'platform' => $podcast->platform,
                'created_at' => $podcast->created_at->format('Y-m-d'),
            ];
        });

        return $this->responseMessage(200, true, 'تم جلب البودكاست بنجاح', $podcasts);
    }
}
