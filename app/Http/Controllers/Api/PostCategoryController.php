<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use App\Traits\ApiResponseTrait;

class PostCategoryController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $categories = PostCategory::latest()->paginate(10);
        return $this->responseMessage(200, true, 'categories', $categories);
    }

}
