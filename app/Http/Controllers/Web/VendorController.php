<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Vendor;

class VendorController extends Controller
{
    public function index()
    {
        $query = Vendor::active()->with(['city', 'categories']);

        if (request('q')) {
            $query->search(request('q'));
        }
        if (request('city')) {
            $query->whereHas('city', fn($q) => $q->where('slug', request('city')));
        }
        if (request('category')) {
            $query->whereHas('categories', fn($q) => $q->where('slug', request('category')));
        }
        if (request('min_rating')) {
            $query->where('rating', '>=', request('min_rating'));
        }
        if (request('verified')) {
            $query->verified();
        }
        if (request('featured')) {
            $query->featured();
        }

        $sort = request('sort', 'rating');
        $dir = request('dir', 'desc');
        $query->orderBy($sort === 'name' ? 'name' : ($sort === 'price' ? 'price_min' : 'rating'), $dir);

        $vendors = $query->paginate(12)->appends(request()->query());

        $categories = Category::active()->ordered()
            ->withCount(['vendors' => fn($q) => $q->active()])
            ->get();

        $cities = City::active()->ordered()
            ->withCount(['vendors' => fn($q) => $q->active()])
            ->get();

        return view('vendors.index', compact('vendors', 'categories', 'cities'));
    }

    public function show($slug)
    {
        $vendor = Vendor::where('slug', $slug)
            ->orWhere('id', $slug)
            ->with(['city', 'categories', 'services' => fn($q) => $q->active(), 'reviews' => fn($q) => $q->approved()->with('user')->latest()])
            ->withCount('reviews')
            ->firstOrFail();

        $relatedVendors = Vendor::active()
            ->where('id', '!=', $vendor->id)
            ->where('city_id', $vendor->city_id)
            ->with(['city', 'categories'])
            ->orderByDesc('rating')
            ->limit(3)
            ->get();

        return view('vendors.show', compact('vendor', 'relatedVendors'));
    }
}
