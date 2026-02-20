@extends('admin.layout')
@section('title', isset($category) ? 'Edit: ' . $category->name : 'New Category')

@section('content')
    <form method="POST"
        action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
        style="max-width:520px">
        @csrf
        @if(isset($category)) @method('PUT') @endif

        <div class="form-card">
            <div class="form-card-h"><span class="mi material-icons-round">sell</span> Category Details</div>
            <div class="form-card-b">
                <div class="fg">
                    <label>Name *</label>
                    <input type="text" name="name" class="fi" value="{{ old('name', $category->name ?? '') }}" required>
                </div>
                <div class="fg-row">
                    <div class="fg">
                        <label>Icon</label>
                        <input type="text" name="icon" class="fi" value="{{ old('icon', $category->icon ?? '') }}"
                            placeholder="camera_alt">
                        <div class="hint">Material Icons name</div>
                    </div>
                    <div class="fg">
                        <label>Color</label>
                        <div style="display:flex;gap:.3rem;align-items:center">
                            <input type="color" name="color" value="{{ old('color', $category->color ?? '#b07272') }}"
                                style="width:30px;height:28px;border:1px solid var(--brd);border-radius:4px;cursor:pointer;padding:0">
                            <input type="text" class="fi" value="{{ old('color', $category->color ?? '#b07272') }}"
                                style="flex:1;font-family:monospace;font-size:.72rem"
                                onchange="this.previousElementSibling.value=this.value" id="colorText">
                        </div>
                    </div>
                </div>
                <div class="fg">
                    <label>Description</label>
                    <textarea name="description" class="fi"
                        rows="3">{{ old('description', $category->description ?? '') }}</textarea>
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
                    <div class="fg" style="display:flex;align-items:flex-end;padding-bottom:.5rem">
                        <div style="display:flex;align-items:center;justify-content:space-between;width:100%">
                            <span style="font-size:.72rem;font-weight:500">Active</span>
                            <label class="tog"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}><span class="sl"></span></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:.4rem">
            <button type="submit" class="btn btn-pri"><span class="mi material-icons-round">save</span>
                {{ isset($category) ? 'Save' : 'Create' }}</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-out">Cancel</a>
        </div>
    </form>
@endsection

@section('js')
    <script>
        document.querySelector('input[name="color"]')?.addEventListener('input', function () {
            document.getElementById('colorText').value = this.value;
        });
    </script>
@endsection