@extends('admin.layout')
@section('title', 'Vendors')

@section('content')
    <!-- Filters -->
    <form class="filters" method="GET">
        <input type="text" name="search" class="fi" placeholder="Search vendors..." value="{{ request('search') }}">
        <select name="status" class="fi">
            <option value="">All Status</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
        </select>
        <select name="city_id" class="fi">
            <option value="">All Cities</option>
            @foreach($cities as $city)
                <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-pri"><span class="mi material-icons-round">search</span> Filter</button>
        <a href="{{ route('admin.vendors.create') }}" class="btn btn-pri"><span class="mi material-icons-round">add</span>
            Add Vendor</a>
    </form>

    <!-- Table -->
    <div class="tbl-wrap">
        <div class="tbl-head">
            <h2>All Vendors ({{ $vendors->total() }})</h2>
        </div>
        <table class="tbl">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>City</th>
                    <th>Categories</th>
                    <th>Price</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Flags</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vendors as $vendor)
                    <tr>
                        <td><strong>{{ $vendor->name }}</strong></td>
                        <td>{{ $vendor->city->name ?? '—' }}</td>
                        <td>
                            @foreach($vendor->categories->take(2) as $cat)
                                <span class="badge badge-rose">{{ $cat->name }}</span>
                            @endforeach
                            @if($vendor->categories->count() > 2)
                                <span class="badge badge-gray">+{{ $vendor->categories->count() - 2 }}</span>
                            @endif
                        </td>
                        <td style="font-size:.78rem">{{ $vendor->price_range_formatted }}</td>
                        <td>
                            @if($vendor->rating > 0)
                                <span style="color:var(--gold)">★</span> {{ number_format($vendor->rating, 1) }}
                            @else
                                <span style="color:var(--t3)">—</span>
                            @endif
                        </td>
                        <td>
                            @if($vendor->status === 'approved')
                                <span class="badge badge-green">Approved</span>
                            @elseif($vendor->status === 'pending')
                                <span class="badge badge-yellow">Pending</span>
                            @elseif($vendor->status === 'rejected')
                                <span class="badge badge-red">Rejected</span>
                            @else
                                <span class="badge badge-gray">{{ ucfirst($vendor->status ?? 'N/A') }}</span>
                            @endif
                        </td>
                        <td>
                            @if($vendor->is_verified)<span class="badge badge-green">✓ Verified</span>@endif
                            @if($vendor->is_featured)<span class="badge badge-rose">★ Featured</span>@endif
                        </td>
                        <td>
                            <div style="display:flex;gap:.35rem">
                                <a href="{{ route('admin.vendors.edit', $vendor) }}" class="btn btn-out btn-sm"><span
                                        class="mi material-icons-round">edit</span></a>
                                <form method="POST" action="{{ route('admin.vendors.destroy', $vendor) }}"
                                    onsubmit="return confirm('Delete this vendor?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-red btn-sm"><span
                                            class="mi material-icons-round">delete</span></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:2rem;color:var(--t3)">No vendors found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($vendors->hasPages())
            <div class="pag">
                @if($vendors->onFirstPage())
                    <span class="dis">‹</span>
                @else
                    <a href="{{ $vendors->previousPageUrl() }}">‹</a>
                @endif

                @foreach($vendors->getUrlRange(1, $vendors->lastPage()) as $page => $url)
                    @if($page == $vendors->currentPage())
                        <span class="cur">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($vendors->hasMorePages())
                    <a href="{{ $vendors->nextPageUrl() }}">›</a>
                @else
                    <span class="dis">›</span>
                @endif
            </div>
        @endif
    </div>
@endsection