<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Traits\ApiResponseTrait;

class GalleryController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $galleries = Gallery::latest()->paginate(10);

        $galleries->through(function ($gallery) {

            $imageUrls = [];
            if (is_array($gallery->images)) {
                foreach ($gallery->images as $image) {
                    $imageUrls[] = asset($image);
                }
            }

            return [
                'id' => $gallery->id,
                'title' => $gallery->title,
                'images' => $imageUrls,
                'created_at' => $gallery->created_at->format('Y-m-d'),
            ];
        });

        return $this->responseMessage(200, true, 'galleries', $galleries);
    }
}
