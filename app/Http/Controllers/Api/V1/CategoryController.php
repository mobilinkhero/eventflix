<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\VendorResource;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * List all active categories
     * GET /api/v1/categories
     */
    public function index(): JsonResponse
    {
        $categories = Category::active()
            ->ordered()
            ->withCount(['vendors' => fn($q) => $q->active()])
            ->get();

        return response()->json([
            'success' => true,
            'data' => CategoryResource::collection($categories),
        ]);
    }

    /**
     * Get category with its vendors
     * GET /api/v1/categories/{category}
     */
    public function show(string $category, Request $request): JsonResponse
    {
        $categoryModel = Category::where('id', $category)
            ->orWhere('slug', $category)
            ->firstOrFail();

        $vendors = Vendor::active()
            ->inCategory($categoryModel->id)
            ->with(['city', 'categories', 'services']);

        if ($request->filled('city_id')) {
            $vendors->inCity($request->city_id);
        }

        if ($request->filled('search')) {
            $vendors->search($request->search);
        }

        $sortBy = $request->input('sort_by', 'rating');
        $sortDir = $request->input('sort_dir', 'desc');
        $vendors->orderBy($sortBy, $sortDir);

        $results = $vendors->paginate($request->input('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => [
                'category' => new CategoryResource($categoryModel),
                'vendors' => VendorResource::collection($results),
            ],
            'meta' => [
                'current_page' => $results->currentPage(),
                'last_page' => $results->lastPage(),
                'total' => $results->total(),
            ],
        ]);
    }
}
