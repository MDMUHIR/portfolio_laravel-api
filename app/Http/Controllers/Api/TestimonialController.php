<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;

class TestimonialController extends Controller
{
    public function index(): JsonResponse
    {
        $testimonials = Testimonial::active()
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => TestimonialResource::collection($testimonials),
        ]);
    }
}
