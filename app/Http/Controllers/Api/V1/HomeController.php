<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\VendorResource;
use App\Models\Banner;
use App\Models\Category;
use App\Models\City;
use App\Models\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Get all home screen data in a single API call (reduces mobile data usage)
     * GET /api/v1/home
     */
    public function index(Request $request): JsonResponse
    {
        $cityId = $request->input('city_id');

        // Banners
        $banners = Banner::active()
            ->forPosition('home_slider')
            ->orderBy('sort_order')
            ->limit(5)
            ->get();

        // Categories with vendor counts
        $categories = Category::active()
            ->ordered()
            ->withCount([
                'vendors' => function ($q) use ($cityId) {
                    $q->active();
                    if ($cityId)
                        $q->inCity($cityId);
                }
            ])
            ->get();

        // Featured vendors
        $featuredQuery = Vendor::active()->featured()->with(['city', 'categories', 'services']);
        if ($cityId)
            $featuredQuery->inCity($cityId);
        $featured = $featuredQuery->orderByDesc('rating')->limit(10)->get();

        // Popular vendors
        $popularQuery = Vendor::active()->with(['city', 'categories', 'services']);
        if ($cityId)
            $popularQuery->inCity($cityId);
        $popular = $popularQuery->orderByDesc('total_bookings')
            ->orderByDesc('rating')
            ->limit(10)
            ->get();

        // New vendors
        $newQuery = Vendor::active()->with(['city', 'categories', 'services']);
        if ($cityId)
            $newQuery->inCity($cityId);
        $newVendors = $newQuery->latest()->limit(10)->get();

        // Cities
        $cities = City::active()
            ->ordered()
            ->withCount(['vendors' => fn($q) => $q->active()])
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'banners' => BannerResource::collection($banners),
                'categories' => CategoryResource::collection($categories),
                'cities' => CityResource::collection($cities),
                'featured_vendors' => VendorResource::collection($featured),
                'popular_vendors' => VendorResource::collection($popular),
                'new_vendors' => VendorResource::collection($newVendors),
            ],
        ]);
    }

    /**
     * Global search across vendors
     * GET /api/v1/search
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'q' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        $query = $request->input('q');

        $vendors = Vendor::active()
            ->search($query)
            ->with(['city', 'categories', 'services'])
            ->orderByDesc('is_featured')
            ->orderByDesc('rating')
            ->paginate($request->input('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => VendorResource::collection($vendors),
            'meta' => [
                'query' => $query,
                'current_page' => $vendors->currentPage(),
                'last_page' => $vendors->lastPage(),
                'total' => $vendors->total(),
            ],
        ]);
    }
}
