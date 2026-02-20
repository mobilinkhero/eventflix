<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::withCount('vendors')->ordered()->paginate(20);
        return view('admin.cities.index', compact('cities'));
    }

    public function create()
    {
        return view('admin.cities.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cities',
            'province' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('cities', 'public');
            $validated['image'] = $path;
        }

        City::create($validated);

        return redirect()->route('admin.cities.index')->with('success', 'City created successfully');
    }

    public function edit(City $city)
    {
        return view('admin.cities.form', compact('city'));
    }

    public function update(Request $request, City $city)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cities,name,' . $city->id,
            'province' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image_file')) {
            // Delete old image if exists
            if ($city->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($city->image);
            }
            $path = $request->file('image_file')->store('cities', 'public');
            $validated['image'] = $path;
        }

        $city->update($validated);

        return redirect()->route('admin.cities.index')->with('success', 'City updated successfully');
    }

    public function destroy(City $city)
    {
        if ($city->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($city->image);
        }
        $city->delete();
        return redirect()->route('admin.cities.index')->with('success', 'City deleted successfully');
    }
}
