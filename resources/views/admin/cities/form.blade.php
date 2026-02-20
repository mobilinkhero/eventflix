@extends('admin.layout')
@section('title', isset($city) ? 'Edit: ' . $city->name : 'New City')

@section('content')
    <form method="POST" action="{{ isset($city) ? route('admin.cities.update', $city) : route('admin.cities.store') }}"
        enctype="multipart/form-data" style="max-width:520px">
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
                    <label>City Icon / Image</label>
                    <div class="drop-zone" id="dropZone" onclick="document.getElementById('fileInput').click()">
                        <div class="drop-zone-inner" id="dropInner">
                            @if(isset($city) && $city->image)
                                <img src="{{ url('uploads/' . $city->image) }}" class="drop-zone-thumb" id="dropThumb">
                                <div class="drop-zone-info">
                                    <span class="drop-zone-name">{{ basename($city->image) }}</span>
                                    <span class="drop-zone-hint">Click or drag to replace</span>
                                </div>
                            @else
                                <span class="mi material-icons-round" style="font-size:2rem;color:var(--t4)">cloud_upload</span>
                                <div class="drop-zone-info">
                                    <span class="drop-zone-name">Choose an image</span>
                                    <span class="drop-zone-hint">PNG, JPG, SVG or WebP (max 2MB)</span>
                                </div>
                            @endif
                        </div>
                        <input type="file" name="image_file" id="fileInput" accept="image/*" style="display:none">
                    </div>
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

    <style>
        .drop-zone {
            border: 2px dashed var(--b2);
            border-radius: 12px;
            padding: 1.5rem;
            cursor: pointer;
            transition: all .2s;
            background: var(--bg-card);
        }

        .drop-zone:hover,
        .drop-zone.dragover {
            border-color: var(--rose);
            background: var(--rose-light);
        }

        .drop-zone-inner {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .drop-zone-thumb {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--b2);
        }

        .drop-zone-info {
            display: flex;
            flex-direction: column;
            gap: .2rem;
        }

        .drop-zone-name {
            font-size: .85rem;
            font-weight: 600;
            color: var(--t1);
        }

        .drop-zone-hint {
            font-size: .72rem;
            color: var(--t3);
        }
    </style>

    <script>
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const dropInner = document.getElementById('dropInner');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(e => {
            dropZone.addEventListener(e, (ev) => {
                ev.preventDefault();
                ev.stopPropagation();
            });
        });

        ['dragenter', 'dragover'].forEach(e => {
            dropZone.addEventListener(e, () => dropZone.classList.add('dragover'));
        });

        ['dragleave', 'drop'].forEach(e => {
            dropZone.addEventListener(e, () => dropZone.classList.remove('dragover'));
        });

        dropZone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if (files.length) {
                fileInput.files = files;
                handleFiles(files[0]);
            }
        });

        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length) handleFiles(e.target.files[0]);
        });

        function handleFiles(file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                dropInner.innerHTML = `
                        <img src="${e.target.result}" class="drop-zone-thumb">
                        <div class="drop-zone-info">
                            <span class="drop-zone-name">${file.name}</span>
                            <span class="drop-zone-hint">Ready to upload</span>
                        </div>
                    `;
            }
            reader.readAsDataURL(file);
        }
    </script>
@endsection