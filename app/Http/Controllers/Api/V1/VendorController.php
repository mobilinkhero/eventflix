<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\VendorResource;
use App\Models\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * List vendors with filtering, sorting, pagination
     * GET /api/v1/vendors
     */
    public function index(Request $request): JsonResponse
    {
        $query = Vendor::query()
            ->active()
            ->with(['city', 'categories', 'services']);

        // ─── Filters ───────────────────────────────
        if ($request->filled('city_id')) {
            $query->inCity($request->city_id);
        }

        if ($request->filled('city_slug')) {
            $query->whereHas('city', fn($q) => $q->where('slug', $request->city_slug));
        }

        if ($request->filled('category_id')) {
            $query->inCategory($request->category_id);
        }

        if ($request->filled('category_slug')) {
            $query->whereHas('categories', fn($q) => $q->where('slug', $request->category_slug));
        }

        if ($request->filled('search') || $request->filled('q')) {
            $search = $request->input('search') ?? $request->input('q');
            $query->search($search);
        }

        if ($request->filled('is_verified')) {
            $query->verified();
        }

        if ($request->filled('is_featured')) {
            $query->featured();
        }

        if ($request->filled('price_min') || $request->filled('price_max')) {
            $query->priceRange($request->price_min, $request->price_max);
        }

        if ($request->filled('min_rating')) {
            $query->minRating($request->min_rating);
        }

        // ─── Sorting ───────────────────────────────
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDir = $request->input('sort_dir', 'desc');

        $allowedSorts = ['name', 'rating', 'price_min', 'total_reviews', 'total_bookings', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        }

        // ─── Pagination ────────────────────────────
        $perPage = min((int) $request->input('per_page', 15), 50);
        $vendors = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => VendorResource::collection($vendors),
            'meta' => [
                'current_page' => $vendors->currentPage(),
                'last_page' => $vendors->lastPage(),
                'per_page' => $vendors->perPage(),
                'total' => $vendors->total(),
            ],
        ]);
    }

    /**
     * Get single vendor by ID or slug
     * GET /api/v1/vendors/{vendor}
     */
    public function show(string $vendor): JsonResponse
    {
        $vendorModel = Vendor::query()
            ->active()
            ->with([
                'city',
                'categories',
                'services',
                'reviews' => function ($q) {
                    $q->approved()->latest()->limit(10);
                },
                'reviews.user'
            ])
            ->where('id', $vendor)
            ->orWhere('slug', $vendor)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => new VendorResource($vendorModel),
        ]);
    }

    /**
     * Get featured vendors
     * GET /api/v1/vendors/featured
     */
    public function featured(Request $request): JsonResponse
    {
        $query = Vendor::query()
            ->active()
            ->featured()
            ->with(['city', 'categories']);

        if ($request->filled('city_id')) {
            $query->inCity($request->city_id);
        }

        $vendors = $query->orderByDesc('rating')
            ->limit($request->input('limit', 10))
            ->get();

        return response()->json([
            'success' => true,
            'data' => VendorResource::collection($vendors),
        ]);
    }

    /**
     * Get popular vendors (most booked)
     * GET /api/v1/vendors/popular
     */
    public function popular(Request $request): JsonResponse
    {
        $query = Vendor::query()
            ->active()
            ->with(['city', 'categories']);

        if ($request->filled('city_id')) {
            $query->inCity($request->city_id);
        }

        $vendors = $query->orderByDesc('total_bookings')
            ->orderByDesc('rating')
            ->limit($request->input('limit', 10))
            ->get();

        return response()->json([
            'success' => true,
            'data' => VendorResource::collection($vendors),
        ]);
    }

    /**
     * Get vendor reviews
     * GET /api/v1/vendors/{vendor}/reviews
     */
    public function reviews(string $vendor, Request $request): JsonResponse
    {
        $vendorModel = Vendor::where('id', $vendor)
            ->orWhere('slug', $vendor)
            ->firstOrFail();

        $reviews = $vendorModel->reviews()
            ->approved()
            ->with('user')
            ->latest()
            ->paginate($request->input('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => \App\Http\Resources\ReviewResource::collection($reviews),
            'meta' => [
                'current_page' => $reviews->currentPage(),
                'last_page' => $reviews->lastPage(),
                'total' => $reviews->total(),
                'average_rating' => round($vendorModel->rating, 1),
                'total_reviews' => $vendorModel->total_reviews,
            ],
        ]);
    }
}
