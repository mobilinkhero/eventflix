<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $query = Vendor::with(['city', 'categories']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        $vendors = $query->latest()->paginate(20);
        $cities = City::active()->ordered()->get();

        return view('admin.vendors.index', compact('vendors', 'cities'));
    }

    public function create()
    {
        $categories = Category::active()->ordered()->get();
        $cities = City::active()->ordered()->get();
        return view('admin.vendors.form', compact('categories', 'cities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:500',
            'price_min' => 'nullable|numeric|min:0',
            'price_max' => 'nullable|numeric|min:0',
            'price_unit' => 'nullable|string|max:50',
            'image' => 'nullable|string|max:500',
            'is_verified' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'status' => 'required|in:pending,approved,rejected,suspended',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $validated['is_verified'] = $request->has('is_verified');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        $vendor = Vendor::create($validated);

        if ($request->has('categories')) {
            $vendor->categories()->sync($request->categories);
        }

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor created successfully');
    }

    public function edit(Vendor $vendor)
    {
        $vendor->load('categories', 'services');
        $categories = Category::active()->ordered()->get();
        $cities = City::active()->ordered()->get();
        return view('admin.vendors.form', compact('vendor', 'categories', 'cities'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:500',
            'price_min' => 'nullable|numeric|min:0',
            'price_max' => 'nullable|numeric|min:0',
            'price_unit' => 'nullable|string|max:50',
            'image' => 'nullable|string|max:500',
            'is_verified' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'status' => 'required|in:pending,approved,rejected,suspended',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $validated['is_verified'] = $request->has('is_verified');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        $vendor->update($validated);
        $vendor->categories()->sync($request->categories ?? []);

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor updated successfully');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return redirect()->route('admin.vendors.index')->with('success', 'Vendor deleted successfully');
    }
}
