<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Traits\ApiResponseTrait;

class ConferenceController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $conferences = Conference::latest()->paginate(10);
        return $this->responseMessage(200, true, 'conferences', $conferences);
    }
}
