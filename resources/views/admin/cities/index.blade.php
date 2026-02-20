@extends('admin.layout')
@section('title', 'Cities')

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem">
        <p style="color:var(--t2);font-size:.84rem">Manage cities for vendor locations</p>
        <a href="{{ route('admin.cities.create') }}" class="btn btn-pri"><span class="mi material-icons-round">add</span>
            Add City</a>
    </div>

    <div class="tbl-wrap">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Province</th>
                    <th>Slug</th>
                    <th>Vendors</th>
                    <th>Active</th>
                    <th>Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cities as $city)
                    <tr>
                        <td><strong>{{ $city->name }}</strong></td>
                        <td>{{ $city->province ?? '—' }}</td>
                        <td style="color:var(--t3);font-size:.78rem">{{ $city->slug }}</td>
                        <td><span class="badge badge-gray">{{ $city->vendors_count }}</span></td>
                        <td>
                            @if($city->is_active)
                                <span class="badge badge-green">Active</span>
                            @else
                                <span class="badge badge-red">Inactive</span>
                            @endif
                        </td>
                        <td style="color:var(--t3)">{{ $city->sort_order ?? '—' }}</td>
                        <td>
                            <div style="display:flex;gap:.35rem">
                                <a href="{{ route('admin.cities.edit', $city) }}" class="btn btn-out btn-sm"><span
                                        class="mi material-icons-round">edit</span></a>
                                <form method="POST" action="{{ route('admin.cities.destroy', $city) }}"
                                    onsubmit="return confirm('Delete this city?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-red btn-sm"><span
                                            class="mi material-icons-round">delete</span></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:2rem;color:var(--t3)">No cities yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($cities->hasPages())
            <div class="pag">
                {{ $cities->links() }}
            </div>
        @endif
    </div>
@endsection