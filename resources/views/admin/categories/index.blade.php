@extends('admin.layout')
@section('title', 'Categories')

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem">
        <p style="color:var(--t2);font-size:.84rem">Manage event categories</p>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-pri"><span
                class="mi material-icons-round">add</span> Add Category</a>
    </div>

    <div class="tbl-wrap">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Icon</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Vendors</th>
                    <th>Active</th>
                    <th>Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr>
                        <td>
                            <div
                                style="width:36px;height:36px;border-radius:8px;background:{{ $cat->color ?? '#c48b8b' }}20;display:flex;align-items:center;justify-content:center">
                                <span class="mi material-icons-round"
                                    style="font-size:18px;color:{{ $cat->color ?? '#c48b8b' }}">{{ $cat->icon ?? 'category' }}</span>
                            </div>
                        </td>
                        <td><strong>{{ $cat->name }}</strong></td>
                        <td style="color:var(--t3);font-size:.78rem">{{ $cat->slug }}</td>
                        <td><span class="badge badge-gray">{{ $cat->vendors_count }}</span></td>
                        <td>
                            @if($cat->is_active)
                                <span class="badge badge-green">Active</span>
                            @else
                                <span class="badge badge-red">Inactive</span>
                            @endif
                        </td>
                        <td style="color:var(--t3)">{{ $cat->sort_order ?? '—' }}</td>
                        <td>
                            <div style="display:flex;gap:.35rem">
                                <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-out btn-sm"><span
                                        class="mi material-icons-round">edit</span></a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                                    onsubmit="return confirm('Delete this category?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-red btn-sm"><span
                                            class="mi material-icons-round">delete</span></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:2rem;color:var(--t3)">No categories yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($categories->hasPages())
            <div class="pag">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
@endsection