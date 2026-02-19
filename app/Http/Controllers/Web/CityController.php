<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Vendor;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::active()->ordered()
            ->withCount(['vendors' => fn($q) => $q->active()])
            ->get();

        return view('cities.index', compact('cities'));
    }

    public function show($slug)
    {
        $city = City::where('slug', $slug)
            ->orWhere('id', $slug)
            ->withCount(['vendors' => fn($q) => $q->active()])
            ->firstOrFail();

        $vendors = Vendor::active()
            ->where('city_id', $city->id)
            ->with(['city', 'categories'])
            ->orderByDesc('rating')
            ->paginate(12);

        return view('cities.show', compact('city', 'vendors'));
    }
}
