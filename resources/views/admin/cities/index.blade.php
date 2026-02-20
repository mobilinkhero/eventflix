@extends('admin.layout')
@section('title', 'Cities')

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.75rem">
        <span style="font-size:.72rem;color:var(--t3)">{{ $cities->total() }} cities</span>
        <a href="{{ route('admin.cities.create') }}" class="btn btn-pri"><span class="mi material-icons-round">add</span>
            New City</a>
    </div>

    <div class="panel">
        <table class="tbl">
            <thead>
                <tr>
                    <th>City</th>
                    <th>Province</th>
                    <th>Slug</th>
                    <th>Vendors</th>
                    <th>Status</th>
                    <th>Order</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cities as $city)
                    <tr>
                        <td class="name">
                            <div style="display:flex;align-items:center;gap:.6rem">
                                <div
                                    style="width:28px;height:28px;border-radius:6px;background:var(--bg2);display:flex;align-items:center;justify-content:center;overflow:hidden">
                                    @if($city->image)
                                        <img src="{{ url('uploads/' . $city->image) }}"
                                            style="width:100%;height:100%;object-fit:cover">
                                    @else
                                        <span class="mi material-icons-round"
                                            style="font-size:14px;color:var(--t4)">apartment</span>
                                    @endif
                                </div>
                                {{ $city->name }}
                            </div>
                        </td>
                        <td style="color:var(--t2)">{{ $city->province ?? '—' }}</td>
                        <td class="mono">{{ $city->slug }}</td>
                        <td><span class="b b-gray">{{ $city->vendors_count }}</span></td>
                        <td>
                            <span class="b-dot {{ $city->is_active ? 'on' : 'off' }}"></span>
                            <span style="font-size:.65rem;color:var(--t3)">{{ $city->is_active ? 'Active' : 'Off' }}</span>
                        </td>
                        <td class="mono">{{ $city->sort_order ?? 0 }}</td>
                        <td>
                            <div class="act-group" style="justify-content:flex-end">
                                <a href="{{ route('admin.cities.edit', $city) }}" class="btn btn-ghost btn-xs"><span
                                        class="mi material-icons-round">edit</span></a>
                                <form method="POST" action="{{ route('admin.cities.destroy', $city) }}"
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
                                <span class="mi material-icons-round">apartment</span>
                                <h3>No cities</h3>
                                <p>Add your first city</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($cities->hasPages())
            <div class="pag">
                <span>{{ $cities->firstItem() }}–{{ $cities->lastItem() }} of {{ $cities->total() }}</span>
                <div class="pag-btns">{{ $cities->links() }}</div>
            </div>
        @endif
    </div>
@endsection