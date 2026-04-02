<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Traits\ApiResponseTrait;

class TestimonialController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);
        return $this->responseMessage(200, true, 'Testimonials', $testimonials);
    }

}
