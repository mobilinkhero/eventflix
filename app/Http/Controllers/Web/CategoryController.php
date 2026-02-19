<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Vendor;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::active()->ordered()
            ->withCount(['vendors' => fn($q) => $q->active()])
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->orWhere('id', $slug)
            ->withCount(['vendors' => fn($q) => $q->active()])
            ->firstOrFail();

        $vendors = Vendor::active()
            ->whereHas('categories', fn($q) => $q->where('categories.id', $category->id))
            ->with(['city', 'categories'])
            ->orderByDesc('rating')
            ->paginate(12);

        return view('categories.show', compact('category', 'vendors'));
    }
}
