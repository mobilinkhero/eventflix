@extends('admin.layout')
@section('title', 'Dashboard')

@section('content')
    <!-- Stats -->
    <div class="stats">
        <div class="stat">
            <div class="stat-icon" style="background:linear-gradient(135deg,#c48b8b,#ad7070)">
                <span class="mi material-icons-round">store</span>
            </div>
            <h3>{{ $stats['vendors'] }}</h3>
            <p>Total Vendors</p>
        </div>
        <div class="stat">
            <div class="stat-icon" style="background:linear-gradient(135deg,#34c759,#28a745)">
                <span class="mi material-icons-round">check_circle</span>
            </div>
            <h3>{{ $stats['active_vendors'] }}</h3>
            <p>Active Vendors</p>
        </div>
        <div class="stat">
            <div class="stat-icon" style="background:linear-gradient(135deg,#c9a961,#ad8d45)">
                <span class="mi material-icons-round">category</span>
            </div>
            <h3>{{ $stats['categories'] }}</h3>
            <p>Categories</p>
        </div>
        <div class="stat">
            <div class="stat-icon" style="background:linear-gradient(135deg,#7a8b9a,#5c6d7e)">
                <span class="mi material-icons-round">location_city</span>
            </div>
            <h3>{{ $stats['cities'] }}</h3>
            <p>Cities</p>
        </div>
    </div>

    <div class="stats" style="grid-template-columns:repeat(4,1fr)">
        <div class="stat">
            <div class="stat-icon" style="background:linear-gradient(135deg,#b8a5d0,#9a85b8)">
                <span class="mi material-icons-round">calendar_today</span>
            </div>
            <h3>{{ $stats['bookings'] }}</h3>
            <p>Bookings</p>
        </div>
        <div class="stat">
            <div class="stat-icon" style="background:linear-gradient(135deg,#ffb800,#e6a700)">
                <span class="mi material-icons-round">star</span>
            </div>
            <h3>{{ $stats['reviews'] }}</h3>
            <p>Reviews</p>
        </div>
        <div class="stat">
            <div class="stat-icon" style="background:linear-gradient(135deg,#5bc0de,#3eafd4)">
                <span class="mi material-icons-round">people</span>
            </div>
            <h3>{{ $stats['users'] }}</h3>
            <p>Users</p>
        </div>
        <div class="stat">
            <div class="stat-icon" style="background:linear-gradient(135deg,#e74c3c,#c0392b)">
                <span class="mi material-icons-round">workspace_premium</span>
            </div>
            <h3>{{ $stats['featured_vendors'] }}</h3>
            <p>Featured</p>
        </div>
    </div>

    <!-- Recent Vendors -->
    <div class="tbl-wrap">
        <div class="tbl-head">
            <h2>Recent Vendors</h2>
            <a href="{{ route('admin.vendors.index') }}" class="btn btn-out btn-sm">View All</a>
        </div>
        <table class="tbl">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>City</th>
                    <th>Status</th>
                    <th>Featured</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentVendors as $vendor)
                    <tr>
                        <td><strong>{{ $vendor->name }}</strong></td>
                        <td>{{ $vendor->city->name ?? '—' }}</td>
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
                            @if($vendor->is_featured)
                                <span class="badge badge-rose">Featured</span>
                            @else
                                <span class="badge badge-gray">No</span>
                            @endif
                        </td>
                        <td style="color:var(--t3);font-size:.78rem">{{ $vendor->created_at?->diffForHumans() ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;color:var(--t3);padding:2rem">No vendors yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Recent Bookings -->
    <div class="tbl-wrap">
        <div class="tbl-head">
            <h2>Recent Bookings</h2>
        </div>
        <table class="tbl">
            <thead>
                <tr>
                    <th>Booking #</th>
                    <th>Vendor</th>
                    <th>Contact</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBookings as $booking)
                    <tr>
                        <td><strong>{{ $booking->booking_number }}</strong></td>
                        <td>{{ $booking->vendor->name ?? '—' }}</td>
                        <td>{{ $booking->contact_name ?? '—' }}</td>
                        <td>{{ $booking->event_date?->format('d M Y') ?? '—' }}</td>
                        <td>
                            <span
                                class="badge badge-{{ $booking->status === 'confirmed' ? 'green' : ($booking->status === 'pending' ? 'yellow' : 'gray') }}">
                                {{ ucfirst($booking->status ?? 'N/A') }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;color:var(--t3);padding:2rem">No bookings yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection