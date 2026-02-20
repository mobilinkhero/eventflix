@extends('admin.layout')
@section('title', isset($category) ? 'Edit Category' : 'Add Category')

@section('content')
    <form method="POST"
        action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
        style="max-width:600px">
        @csrf
        @if(isset($category)) @method('PUT') @endif

        <div class="form-card">
            <h2>Category Details</h2>
            <div class="fg">
                <label>Name *</label>
                <input type="text" name="name" class="fi" value="{{ old('name', $category->name ?? '') }}" required>
            </div>
            <div class="fg-row">
                <div class="fg">
                    <label>Icon (Material Icons name)</label>
                    <input type="text" name="icon" class="fi" value="{{ old('icon', $category->icon ?? '') }}"
                        placeholder="e.g. camera_alt">
                </div>
                <div class="fg">
                    <label>Color (hex)</label>
                    <input type="text" name="color" class="fi" value="{{ old('color', $category->color ?? '#c48b8b') }}"
                        placeholder="#c48b8b">
                </div>
            </div>
            <div class="fg">
                <label>Description</label>
                <textarea name="description" class="fi">{{ old('description', $category->description ?? '') }}</textarea>
            </div>
            <div class="fg">
                <label>Image URL</label>
                <input type="text" name="image" class="fi" value="{{ old('image', $category->image ?? '') }}"
                    placeholder="https://...">
            </div>
            <div class="fg-row">
                <div class="fg">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" class="fi"
                        value="{{ old('sort_order', $category->sort_order ?? 0) }}" min="0">
                </div>
                <div class="fg" style="display:flex;align-items:flex-end">
                    <div class="fg-check">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                        <label for="is_active">Active</label>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:.75rem">
            <button type="submit" class="btn btn-pri"><span class="mi material-icons-round">save</span>
                {{ isset($category) ? 'Update' : 'Create' }} Category</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-out">Cancel</a>
        </div>
    </form>
@endsection