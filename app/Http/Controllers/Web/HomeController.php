<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\City;
use App\Models\Review;
use App\Models\Vendor;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::active()->ordered()
            ->withCount(['vendors' => fn($q) => $q->active()])
            ->get();

        $featuredVendors = Vendor::active()->featured()
            ->with(['city', 'categories'])
            ->orderByDesc('rating')
            ->limit(6)
            ->get();

        $cities = City::active()->ordered()
            ->withCount(['vendors' => fn($q) => $q->active()])
            ->get();

        $stats = [
            'vendors' => Vendor::active()->count(),
            'cities' => City::active()->count(),
            'categories' => Category::active()->count(),
            'reviews' => Review::where('status', 'approved')->count(),
        ];

        return view('home', compact('categories', 'featuredVendors', 'cities', 'stats'));
    }

    public function search()
    {
        $q = request('q', '');

        $vendors = Vendor::active()
            ->when($q, fn($query) => $query->search($q))
            ->with(['city', 'categories'])
            ->orderByDesc('rating')
            ->paginate(12)
            ->appends(['q' => $q]);

        return view('search', compact('vendors', 'q'));
    }
}
