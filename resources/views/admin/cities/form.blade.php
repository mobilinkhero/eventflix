@extends('admin.layout')
@section('title', isset($city) ? 'Edit City' : 'Add City')

@section('content')
    <form method="POST" action="{{ isset($city) ? route('admin.cities.update', $city) : route('admin.cities.store') }}"
        style="max-width:600px">
        @csrf
        @if(isset($city)) @method('PUT') @endif

        <div class="form-card">
            <h2>City Details</h2>
            <div class="fg-row">
                <div class="fg">
                    <label>Name *</label>
                    <input type="text" name="name" class="fi" value="{{ old('name', $city->name ?? '') }}" required>
                </div>
                <div class="fg">
                    <label>Province</label>
                    <input type="text" name="province" class="fi" value="{{ old('province', $city->province ?? '') }}"
                        placeholder="e.g. Punjab">
                </div>
            </div>
            <div class="fg">
                <label>Image URL</label>
                <input type="text" name="image" class="fi" value="{{ old('image', $city->image ?? '') }}"
                    placeholder="https://...">
            </div>
            <div class="fg-row">
                <div class="fg">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" class="fi"
                        value="{{ old('sort_order', $city->sort_order ?? 0) }}" min="0">
                </div>
                <div class="fg" style="display:flex;align-items:flex-end">
                    <div class="fg-check">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $city->is_active ?? true) ? 'checked' : '' }}>
                        <label for="is_active">Active</label>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:.75rem">
            <button type="submit" class="btn btn-pri"><span class="mi material-icons-round">save</span>
                {{ isset($city) ? 'Update' : 'Create' }} City</button>
            <a href="{{ route('admin.cities.index') }}" class="btn btn-out">Cancel</a>
        </div>
    </form>
@endsection