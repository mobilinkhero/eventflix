<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\JsonResponse;

class CityController extends Controller
{
    /**
     * List all active cities
     * GET /api/v1/cities
     */
    public function index(): JsonResponse
    {
        $cities = City::active()
            ->ordered()
            ->withCount(['vendors' => fn($q) => $q->active()])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $cities->map(fn($city) => [
                'id' => $city->id,
                'name' => $city->name,
                'slug' => $city->slug,
                'province' => $city->province,
                'image' => $city->image ? url('storage/' . $city->image) : null,
                'vendor_count' => $city->vendors_count,
            ]),
        ]);
    }

    /**
     * Get single city details
     * GET /api/v1/cities/{city}
     */
    public function show(string $city): JsonResponse
    {
        $cityModel = City::active()
            ->where('id', $city)
            ->orWhere('slug', $city)
            ->withCount(['vendors' => fn($q) => $q->active()])
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $cityModel->id,
                'name' => $cityModel->name,
                'slug' => $cityModel->slug,
                'province' => $cityModel->province,
                'image' => $cityModel->image ? url('storage/' . $cityModel->image) : null,
                'vendor_count' => $cityModel->vendors_count,
            ],
        ]);
    }
}
