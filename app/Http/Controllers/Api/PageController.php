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
        $pages = Page::latest()->get();
        return $this->responseMessage(200, true, 'Pages', $pages);
    }
}
