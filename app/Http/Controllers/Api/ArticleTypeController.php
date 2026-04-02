<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ArticleType;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class ArticleTypeController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $types = ArticleType::latest()->get();
        return $this->responseMessage(200, true, 'Article Types', $types);
    }
}
