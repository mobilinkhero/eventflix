@extends('admin.layout')
@section('title', 'Categories')

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.75rem">
        <span style="font-size:.72rem;color:var(--t3)">{{ $categories->total() }} categories</span>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-pri"><span
                class="mi material-icons-round">add</span> New Category</a>
    </div>

    <div class="panel">
        <table class="tbl">
            <thead>
                <tr>
                    <th style="width:40px">Icon</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Vendors</th>
                    <th>Status</th>
                    <th>Order</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr>
                        <td>
                            <div
                                style="width:28px;height:28px;border-radius:6px;background:{{ $cat->color ?? '#b07272' }}18;display:flex;align-items:center;justify-content:center;overflow:hidden">
                                @if(str_starts_with($cat->icon ?? '', 'uploaded:'))
                                    <img src="{{ url('uploads/' . str_replace('uploaded:', '', $cat->icon)) }}"
                                        style="width:20px;height:20px;object-fit:contain">
                                @else
                                    <span class="mi material-icons-round"
                                        style="font-size:14px;color:{{ $cat->color ?? '#b07272' }}">{{ $cat->icon ?? 'category' }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="name">{{ $cat->name }}</td>
                        <td class="mono">{{ $cat->slug }}</td>
                        <td><span class="b b-gray">{{ $cat->vendors_count }}</span></td>
                        <td>
                            <span class="b-dot {{ $cat->is_active ? 'on' : 'off' }}"></span>
                            <span style="font-size:.65rem;color:var(--t3)">{{ $cat->is_active ? 'Active' : 'Off' }}</span>
                        </td>
                        <td class="mono">{{ $cat->sort_order ?? 0 }}</td>
                        <td>
                            <div class="act-group" style="justify-content:flex-end">
                                <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-ghost btn-xs"><span
                                        class="mi material-icons-round">edit</span></a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                                    onsubmit="return confirm('Delete?')" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-ghost btn-xs" style="color:var(--red)"><span
                                            class="mi material-icons-round">delete_outline</span></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <span class="mi material-icons-round">sell</span>
                                <h3>No categories</h3>
                                <p>Create your first category</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($categories->hasPages())
            <div class="pag">
                <span>{{ $categories->firstItem() }}–{{ $categories->lastItem() }} of {{ $categories->total() }}</span>
                <div class="pag-btns">{{ $categories->links() }}</div>
            </div>
        @endif
    </div>
@endsection