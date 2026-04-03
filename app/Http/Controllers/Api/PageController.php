<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Traits\ApiResponseTrait;

class PageController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $pages = Page::latest()->get()->map(function ($page) {

            $imageUrls = [];
            if (is_array($page->images)) {
                foreach ($page->images as $image) {
                    $imageUrls[] = asset($image);
                }
            }

            return [
                'id' => $page->id,
                'title' => $page->title,
                'slug' => $page->slug,
                'content' => $page->content,
                'pdf_url' => $page->pdf_file ? asset($page->pdf_file) : null,
                'images_urls' => $imageUrls,

                'created_at' => $page->created_at->format('Y-m-d'),
            ];
        });

        return $this->responseMessage(200, true, 'تم جلب الصفحات بنجاح', $pages);
    }
}
