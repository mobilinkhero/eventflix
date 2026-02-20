@extends('admin.layout')
@section('title', 'Vendors')

@section('content')
    <!-- Filters -->
    <form class="filters" method="GET">
        <input type="text" name="search" class="fi" placeholder="Search vendors..." value="{{ request('search') }}" style="max-width:200px">
        <select name="status" class="fi" style="max-width:130px">
            <option value="">All Status</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
        </select>
        <select name="city_id" class="fi" style="max-width:130px">
            <option value="">All Cities</option>
            @foreach($cities as $city)
                <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-pri"><span class="mi material-icons-round">filter_list</span> Filter</button>
        @if(request()->hasAny(['search','status','city_id']))
            <a href="{{ route('admin.vendors.index') }}" class="btn btn-ghost"><span class="mi material-icons-round">close</span> Clear</a>
        @endif
        <div style="flex:1"></div>
        <a href="{{ route('admin.vendors.create') }}" class="btn btn-rose"><span class="mi material-icons-round">add</span> New Vendor</a>
    </form>

    <!-- Table -->
    <div class="panel">
        <table class="tbl">
            <thead>
                <tr>
                    <th style="width:24px"><input type="checkbox" id="selectAll" style="accent-color:var(--pri-d)"></th>
                    <th>Vendor</th>
                    <th>Categories</th>
                    <th>Price Range</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Active</th>
                    <th>Featured</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vendors as $vendor)
                    <tr>
                        <td><input type="checkbox" class="row-check" value="{{ $vendor->id }}" style="accent-color:var(--pri-d)"></td>
                        <td>
                            <span class="name">{{ $vendor->name }}</span>
                            <span class="sub">{{ $vendor->city->name ?? '—' }} · #{{ $vendor->id }}</span>
                        </td>
                        <td>
                            @foreach($vendor->categories->take(2) as $cat)
                                <span class="b b-rose">{{ Str::limit($cat->name, 12) }}</span>
                            @endforeach
                            @if($vendor->categories->count() > 2)
                                <span class="b b-gray">+{{ $vendor->categories->count() - 2 }}</span>
                            @endif
                        </td>
                        <td class="mono">{{ $vendor->price_range_formatted }}</td>
                        <td>
                            @if($vendor->rating > 0)
                                <span style="color:var(--yellow)">★</span> {{ number_format($vendor->rating, 1) }}
                                <span class="sub">{{ $vendor->total_reviews }} rev</span>
                            @else
                                <span style="color:var(--t4)">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="b b-{{ $vendor->status === 'approved' ? 'green' : ($vendor->status === 'pending' ? 'yellow' : ($vendor->status === 'rejected' ? 'red' : 'gray')) }}">
                                {{ ucfirst($vendor->status ?? 'N/A') }}
                            </span>
                        </td>
                        <td>
                            <span class="b-dot {{ $vendor->is_active ? 'on' : 'off' }}"></span>
                        </td>
                        <td>
                            @if($vendor->is_featured)
                                <span class="b b-rose">★</span>
                            @else
                                <span style="color:var(--t4)">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="act-group" style="justify-content:flex-end">
                                <a href="{{ route('admin.vendors.edit', $vendor) }}" class="btn btn-ghost btn-xs" title="Edit"><span class="mi material-icons-round">edit</span></a>
                                <form method="POST" action="{{ route('admin.vendors.destroy', $vendor) }}" onsubmit="return confirm('Delete {{ $vendor->name }}?')" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-ghost btn-xs" title="Delete" style="color:var(--red)"><span class="mi material-icons-round">delete_outline</span></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9">
                        <div class="empty-state">
                            <span class="mi material-icons-round">storefront</span>
                            <h3>No vendors found</h3>
                            <p>Try adjusting your filters or add a new vendor</p>
                        </div>
                    </td></tr>
                @endforelse
            </tbody>
        </table>

        @if($vendors->hasPages())
            <div class="pag">
                <span>Showing {{ $vendors->firstItem() }}–{{ $vendors->lastItem() }} of {{ $vendors->total() }}</span>
                <div class="pag-btns">
                    @if($vendors->onFirstPage())
                        <span class="dis">‹</span>
                    @else
                        <a href="{{ $vendors->previousPageUrl() }}">‹</a>
                    @endif

                    @foreach($vendors->getUrlRange(max(1, $vendors->currentPage()-2), min($vendors->lastPage(), $vendors->currentPage()+2)) as $page => $url)
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
            </div>
        @endif
    </div>
@endsection

@section('js')
<script>
document.getElementById('selectAll')?.addEventListener('change',function(){
    document.querySelectorAll('.row-check').forEach(c=>c.checked=this.checked);
});
</script>
@endsection