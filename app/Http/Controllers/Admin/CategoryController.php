<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('vendors')->ordered()->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'icon' => 'nullable|string|max:50',
            'icon_image' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
            'color' => 'nullable|string|max:7',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Handle icon image upload
        if ($request->hasFile('icon_image')) {
            $path = $request->file('icon_image')->store('category-icons', 'public');
            $validated['icon'] = 'uploaded:' . $path;
        }

        unset($validated['icon_image']);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'icon' => 'nullable|string|max:50',
            'icon_image' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
            'color' => 'nullable|string|max:7',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Handle icon image upload
        if ($request->hasFile('icon_image')) {
            // Delete old uploaded icon if exists
            if (str_starts_with($category->icon ?? '', 'uploaded:')) {
                $oldPath = str_replace('uploaded:', '', $category->icon);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('icon_image')->store('category-icons', 'public');
            $validated['icon'] = 'uploaded:' . $path;
        }

        // If user chose to remove the uploaded image
        if ($request->input('remove_icon_image') === '1') {
            if (str_starts_with($category->icon ?? '', 'uploaded:')) {
                $oldPath = str_replace('uploaded:', '', $category->icon);
                Storage::disk('public')->delete($oldPath);
            }
            // Keep the material icon from the hidden input, or default
            $validated['icon'] = $request->input('icon', 'category');
        }

        unset($validated['icon_image']);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        // Delete uploaded icon if exists
        if (str_starts_with($category->icon ?? '', 'uploaded:')) {
            $oldPath = str_replace('uploaded:', '', $category->icon);
            Storage::disk('public')->delete($oldPath);
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully');
    }
}
