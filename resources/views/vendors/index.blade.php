@extends('layouts.app')
@section('title', 'Find Vendors — EventsWally')

@section('body')
    <div class="ph">
        <div class="wrap">
            <div class="crumb"><a href="{{ route('home') }}">Home</a> <span>›</span> Vendors</div>
            <h1>Find Your Wedding Team</h1>
            <p>{{ $vendors->total() }} vendors ready to make your day special</p>
        </div>
    </div>
    <section class="sec">
        <div class="wrap">
            <div class="pg-flex">
                <aside class="sidebar">
                    <div class="sb-card">
                        <h3>Search</h3>
                        <form action="{{ route('vendors.index') }}" method="GET">
                            @foreach(request()->except(['q', 'page']) as $k => $v)
                                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                            @endforeach
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search vendors..."
                                class="fi" style="font-size:.82rem;border-radius:50px;padding-left:1rem">
                        </form>
                    </div>
                    <div class="sb-card">
                        <h3>Category</h3>
                        <ul class="sb-list">
                            <li><a href="{{ route('vendors.index', request()->except(['category', 'page'])) }}"
                                    class="{{ !request('category') ? 'on' : '' }}">All Categories</a></li>
                            @foreach($categories as $cat)
                                <li><a href="{{ route('vendors.index', array_merge(request()->except('page'), ['category' => $cat->slug])) }}"
                                        class="{{ request('category') === $cat->slug ? 'on' : '' }}">{{ $cat->name }} <span
                                            class="cnt">{{ $cat->vendors_count }}</span></a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="sb-card">
                        <h3>City</h3>
                        <ul class="sb-list">
                            <li><a href="{{ route('vendors.index', request()->except(['city', 'page'])) }}"
                                    class="{{ !request('city') ? 'on' : '' }}">All Cities</a></li>
                            @foreach($cities as $city)
                                <li><a href="{{ route('vendors.index', array_merge(request()->except('page'), ['city' => $city->slug])) }}"
                                        class="{{ request('city') === $city->slug ? 'on' : '' }}">{{ $city->name }} <span
                                            class="cnt">{{ $city->vendors_count }}</span></a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="sb-card">
                        <h3>Rating</h3>
                        <ul class="sb-list">
                            <li><a href="{{ route('vendors.index', request()->except(['min_rating', 'page'])) }}"
                                    class="{{ !request('min_rating') ? 'on' : '' }}">Any Rating</a></li>
                            @foreach([4, 3, 2] as $r)
                                <li><a href="{{ route('vendors.index', array_merge(request()->except('page'), ['min_rating' => $r])) }}"
                                        class="{{ request('min_rating') == $r ? 'on' : '' }}">{{ $r }}+ Stars</a></li>
                            @endforeach
                        </ul>
                    </div>
                </aside>

                <div class="main">
                    @if(request()->hasAny(['q', 'category', 'city', 'min_rating']))
                        <div style="display:flex;flex-wrap:wrap;gap:.4rem;margin-bottom:1.25rem;align-items:center">
                            @if(request('q'))<a href="{{ route('vendors.index', request()->except(['q', 'page'])) }}"
                                class="btn btn-o"
                                style="font-size:.75rem;padding:.25rem .65rem;border-radius:50px">"{{ request('q') }}"
                            ×</a>@endif
                            @if(request('category'))<a
                                href="{{ route('vendors.index', request()->except(['category', 'page'])) }}" class="btn btn-o"
                                style="font-size:.75rem;padding:.25rem .65rem;border-radius:50px">{{ ucfirst(str_replace('-', ' ', request('category'))) }}
                            ×</a>@endif
                            @if(request('city'))<a href="{{ route('vendors.index', request()->except(['city', 'page'])) }}"
                                class="btn btn-o"
                                style="font-size:.75rem;padding:.25rem .65rem;border-radius:50px">{{ ucfirst(request('city')) }}
                            ×</a>@endif
                            <a href="{{ route('vendors.index') }}"
                                style="font-size:.76rem;color:var(--rose-deep);margin-left:.35rem">Clear all</a>
                        </div>
                    @endif

                    @if($vendors->count())
                        <div class="g2">
                            @foreach($vendors as $vendor)
                                @include('partials.vendor-card')
                            @endforeach
                        </div>
                        {{ $vendors->links('partials.pagination') }}
                    @else
                        <div class="empty">
                            <span class="material-icons-round mi">search_off</span>
                            <h3>No vendors found</h3>
                            <p>Try adjusting your filters or search term.</p>
                            <a href="{{ route('vendors.index') }}" class="btn btn-p" style="margin-top:.75rem">Clear Filters</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection