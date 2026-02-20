@extends('admin.layout')
@section('title', 'Dashboard')

@section('content')
    <!-- Row 1: Key Stats -->
    <div class="stats">
        <div class="stat">
            <div class="stat-ic" style="background:linear-gradient(135deg,#b07272,#964f4f)">
                <span class="mi material-icons-round">storefront</span>
            </div>
            <div class="stat-d">
                <h3>{{ $stats['vendors'] }}</h3>
                <p>Total Vendors</p>
            </div>
        </div>
        <div class="stat">
            <div class="stat-ic" style="background:linear-gradient(135deg,#22c55e,#16a34a)">
                <span class="mi material-icons-round">verified</span>
            </div>
            <div class="stat-d">
                <h3>{{ $stats['active_vendors'] }}</h3>
                <p>Active</p>
            </div>
        </div>
        <div class="stat">
            <div class="stat-ic" style="background:linear-gradient(135deg,#eab308,#ca8a04)">
                <span class="mi material-icons-round">sell</span>
            </div>
            <div class="stat-d">
                <h3>{{ $stats['categories'] }}</h3>
                <p>Categories</p>
            </div>
        </div>
        <div class="stat">
            <div class="stat-ic" style="background:linear-gradient(135deg,#3b82f6,#2563eb)">
                <span class="mi material-icons-round">apartment</span>
            </div>
            <div class="stat-d">
                <h3>{{ $stats['cities'] }}</h3>
                <p>Cities</p>
            </div>
        </div>
    </div>

    <div class="stats">
        <div class="stat">
            <div class="stat-ic" style="background:linear-gradient(135deg,#a855f7,#7c3aed)">
                <span class="mi material-icons-round">event_note</span>
            </div>
            <div class="stat-d">
                <h3>{{ $stats['bookings'] }}</h3>
                <p>Bookings</p>
            </div>
        </div>
        <div class="stat">
            <div class="stat-ic" style="background:linear-gradient(135deg,#f97316,#ea580c)">
                <span class="mi material-icons-round">reviews</span>
            </div>
            <div class="stat-d">
                <h3>{{ $stats['reviews'] }}</h3>
                <p>Reviews</p>
            </div>
        </div>
        <div class="stat">
            <div class="stat-ic" style="background:linear-gradient(135deg,#06b6d4,#0891b2)">
                <span class="mi material-icons-round">group</span>
            </div>
            <div class="stat-d">
                <h3>{{ $stats['users'] }}</h3>
                <p>Users</p>
            </div>
        </div>
        <div class="stat">
            <div class="stat-ic" style="background:linear-gradient(135deg,#ec4899,#db2777)">
                <span class="mi material-icons-round">workspace_premium</span>
            </div>
            <div class="stat-d">
                <h3>{{ $stats['featured_vendors'] }}</h3>
                <p>Featured</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div style="display:flex;gap:.4rem;margin-bottom:1.25rem;flex-wrap:wrap">
        <a href="{{ route('admin.vendors.create') }}" class="btn btn-pri"><span class="mi material-icons-round">add</span>
            Add Vendor</a>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-out"><span
                class="mi material-icons-round">add</span> Add Category</a>
        <a href="{{ route('admin.cities.create') }}" class="btn btn-out"><span class="mi material-icons-round">add</span>
            Add City</a>
    </div>

    <!-- Tables Side by Side -->
    <div class="grid-3">
        <!-- Recent Vendors -->
        <div class="panel">
            <div class="panel-h">
                <h2><span class="mi material-icons-round">storefront</span> Recent Vendors</h2>
                <a href="{{ route('admin.vendors.index') }}" class="btn btn-ghost btn-xs">View All →</a>
            </div>
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Vendor</th>
                        <th>Status</th>
                        <th>Flags</th>
                        <th>Added</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentVendors as $v)
                        <tr>
                            <td>
                                <span class="name">{{ $v->name }}</span>
                                <span class="sub">{{ $v->city->name ?? '—' }}</span>
                            </td>
                            <td>
                                <span
                                    class="b b-{{ $v->status === 'approved' ? 'green' : ($v->status === 'pending' ? 'yellow' : ($v->status === 'rejected' ? 'red' : 'gray')) }}">{{ ucfirst($v->status ?? 'N/A') }}</span>
                            </td>
                            <td>
                                @if($v->is_featured)<span class="b b-rose">★</span>@endif
                                @if($v->is_verified)<span class="b b-blue">✓</span>@endif
                            </td>
                            <td class="mono">{{ $v->created_at?->format('d M') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-state">
                                <p>No vendors yet</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Recent Bookings -->
        <div class="panel">
            <div class="panel-h">
                <h2><span class="mi material-icons-round">event_note</span> Bookings</h2>
            </div>
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Booking</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $bk)
                        <tr>
                            <td>
                                <span class="name">{{ $bk->booking_number }}</span>
                                <span class="sub">{{ $bk->vendor->name ?? '—' }} ·
                                    {{ $bk->event_date?->format('d M') ?? '—' }}</span>
                            </td>
                            <td>
                                <span
                                    class="b b-{{ $bk->status === 'confirmed' ? 'green' : ($bk->status === 'pending' ? 'yellow' : 'gray') }}">{{ ucfirst($bk->status ?? 'N/A') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="empty-state">
                                <p>No bookings</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection