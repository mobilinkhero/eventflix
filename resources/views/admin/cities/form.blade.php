@extends('admin.layout')
@section('title', isset($city) ? 'Edit: ' . $city->name : 'New City')

@section('content')
    <form method="POST" action="{{ isset($city) ? route('admin.cities.update', $city) : route('admin.cities.store') }}"
        style="max-width:520px">
        @csrf
        @if(isset($city)) @method('PUT') @endif

        <div class="form-card">
            <div class="form-card-h"><span class="mi material-icons-round">apartment</span> City Details</div>
            <div class="form-card-b">
                <div class="fg-row">
                    <div class="fg">
                        <label>Name *</label>
                        <input type="text" name="name" class="fi" value="{{ old('name', $city->name ?? '') }}" required>
                    </div>
                    <div class="fg">
                        <label>Province</label>
                        <input type="text" name="province" class="fi" value="{{ old('province', $city->province ?? '') }}"
                            placeholder="Punjab">
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
                    <div class="fg" style="display:flex;align-items:flex-end;padding-bottom:.5rem">
                        <div style="display:flex;align-items:center;justify-content:space-between;width:100%">
                            <span style="font-size:.72rem;font-weight:500">Active</span>
                            <label class="tog"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $city->is_active ?? true) ? 'checked' : '' }}><span class="sl"></span></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:.4rem">
            <button type="submit" class="btn btn-pri"><span class="mi material-icons-round">save</span>
                {{ isset($city) ? 'Save' : 'Create' }}</button>
            <a href="{{ route('admin.cities.index') }}" class="btn btn-out">Cancel</a>
        </div>
    </form>
@endsection