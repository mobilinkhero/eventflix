<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — EventsWally</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        :root {
            --pri: #b07272;
            --pri-d: #964f4f;
            --pri-l: #f5e6e6;
            --pri-xl: #faf2f2;
            --bg: #f7f6f4;
            --card: #fff;
            --dark: #1e1b1b;
            --dark2: #282424;
            --t1: #111;
            --t2: #555;
            --t3: #999;
            --t4: #bbb;
            --brd: #ece9e6;
            --brd2: #f3f1ef;
            --green: #22c55e;
            --green-bg: #dcfce7;
            --red: #ef4444;
            --red-bg: #fee2e2;
            --yellow: #eab308;
            --yellow-bg: #fef9c3;
            --blue: #3b82f6;
            --blue-bg: #dbeafe;
            --sb-w: 220px;
            --sb-cw: 60px;
            --top-h: 48px;
            --radius: 8px;
            --radius-sm: 6px;
        }

        html {
            scroll-behavior: smooth;
            font-size: 13px
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg);
            color: var(--t1);
            -webkit-font-smoothing: antialiased;
            display: flex;
            min-height: 100vh;
            overflow-x: hidden
        }

        a {
            color: inherit;
            text-decoration: none
        }

        ::selection {
            background: var(--pri-l);
            color: var(--pri-d)
        }

        /* ═══ SIDEBAR ═══ */
        .sb {
            width: var(--sb-w);
            background: var(--dark);
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: width .2s ease
        }

        .sb-top {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .7rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, .06);
            height: var(--top-h)
        }

        .sb-top .logo-mark {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--pri), var(--pri-d));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: .7rem;
            flex-shrink: 0
        }

        .sb-top .logo-text {
            font-size: .85rem;
            font-weight: 700;
            letter-spacing: -.3px;
            white-space: nowrap
        }

        .sb-top .logo-text span {
            color: var(--pri);
            font-weight: 400
        }

        .sb-nav {
            flex: 1;
            padding: .4rem 0;
            overflow-y: auto;
            overflow-x: hidden
        }

        .sb-label {
            font-size: .6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: rgba(255, 255, 255, .25);
            padding: .65rem 1rem .3rem;
            white-space: nowrap
        }

        .sb-nav a {
            display: flex;
            align-items: center;
            gap: .55rem;
            padding: .4rem 1rem;
            font-size: .78rem;
            font-weight: 500;
            color: rgba(255, 255, 255, .45);
            transition: all .12s;
            border-left: 2px solid transparent;
            white-space: nowrap
        }

        .sb-nav a:hover {
            color: rgba(255, 255, 255, .85);
            background: rgba(255, 255, 255, .04)
        }

        .sb-nav a.on {
            color: #fff;
            background: rgba(255, 255, 255, .08);
            border-left-color: var(--pri)
        }

        .sb-nav a .mi {
            font-size: 17px;
            width: 20px;
            text-align: center;
            flex-shrink: 0
        }

        .sb-nav a .cnt {
            margin-left: auto;
            font-size: .6rem;
            font-weight: 700;
            background: var(--pri);
            color: #fff;
            padding: .1rem .4rem;
            border-radius: 10px;
            min-width: 18px;
            text-align: center
        }

        .sb-ft {
            padding: .6rem 1rem;
            border-top: 1px solid rgba(255, 255, 255, .05);
            display: flex;
            align-items: center;
            gap: .5rem
        }

        .sb-ft .av {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: var(--pri);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .6rem;
            font-weight: 700;
            flex-shrink: 0
        }

        .sb-ft div {
            white-space: nowrap
        }

        .sb-ft .n {
            font-size: .72rem;
            font-weight: 600
        }

        .sb-ft .r {
            font-size: .6rem;
            color: rgba(255, 255, 255, .35)
        }

        /* ═══ MAIN ═══ */
        .main {
            margin-left: var(--sb-w);
            flex: 1;
            min-height: 100vh;
            transition: margin .2s
        }

        .topbar {
            background: var(--card);
            padding: 0 1.5rem;
            height: var(--top-h);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--brd);
            position: sticky;
            top: 0;
            z-index: 50
        }

        .topbar-l {
            display: flex;
            align-items: center;
            gap: .75rem
        }

        .topbar-l h1 {
            font-size: .9rem;
            font-weight: 700
        }

        .crumb {
            display: flex;
            align-items: center;
            gap: .3rem;
            font-size: .72rem;
            color: var(--t3)
        }

        .crumb a {
            color: var(--t2)
        }

        .crumb a:hover {
            color: var(--pri-d)
        }

        .crumb .sep {
            color: var(--t4)
        }

        .topbar-r {
            display: flex;
            align-items: center;
            gap: .5rem
        }

        .topbar-r .tb-btn {
            background: none;
            border: 1px solid var(--brd);
            border-radius: var(--radius-sm);
            cursor: pointer;
            padding: .3rem .5rem;
            font-size: .72rem;
            font-weight: 600;
            color: var(--t2);
            display: flex;
            align-items: center;
            gap: .25rem;
            font-family: inherit;
            transition: all .12s
        }

        .topbar-r .tb-btn:hover {
            border-color: var(--pri);
            color: var(--pri-d)
        }

        .topbar-r .tb-btn .mi {
            font-size: 14px
        }

        .topbar-r .tb-btn.danger:hover {
            border-color: var(--red);
            color: var(--red)
        }

        .content {
            padding: 1.25rem 1.5rem
        }

        /* ═══ STATS ═══ */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: .75rem;
            margin-bottom: 1.25rem
        }

        .stat {
            background: var(--card);
            border-radius: var(--radius);
            padding: .85rem 1rem;
            border: 1px solid var(--brd);
            display: flex;
            align-items: center;
            gap: .85rem;
            transition: border-color .15s
        }

        .stat:hover {
            border-color: var(--pri)
        }

        .stat-ic {
            width: 36px;
            height: 36px;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0
        }

        .stat-ic .mi {
            font-size: 18px;
            color: #fff
        }

        .stat-d h3 {
            font-size: 1.3rem;
            font-weight: 800;
            line-height: 1
        }

        .stat-d p {
            font-size: .65rem;
            color: var(--t3);
            font-weight: 500;
            margin-top: .1rem
        }

        /* ═══ GRID ═══ */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .75rem
        }

        .grid-3 {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: .75rem
        }

        /* ═══ TABLE ═══ */
        .panel {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--brd);
            overflow: hidden;
            margin-bottom: 1rem
        }

        .panel-h {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .65rem 1rem;
            border-bottom: 1px solid var(--brd)
        }

        .panel-h h2 {
            font-size: .8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: .4rem
        }

        .panel-h h2 .mi {
            font-size: 15px;
            color: var(--t3)
        }

        .panel-h .acts {
            display: flex;
            gap: .35rem
        }

        .tbl {
            width: 100%;
            border-collapse: collapse
        }

        .tbl th {
            text-align: left;
            font-size: .62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .7px;
            color: var(--t3);
            padding: .5rem 1rem;
            background: var(--bg);
            border-bottom: 1px solid var(--brd)
        }

        .tbl td {
            padding: .45rem 1rem;
            font-size: .78rem;
            border-bottom: 1px solid var(--brd2);
            vertical-align: middle
        }

        .tbl tr:last-child td {
            border-bottom: none
        }

        .tbl tr:hover td {
            background: #fdfcfb
        }

        .tbl .name {
            font-weight: 600
        }

        .tbl .sub {
            font-size: .65rem;
            color: var(--t3);
            display: block
        }

        .tbl .mono {
            font-family: 'SF Mono', 'Fira Code', monospace;
            font-size: .68rem;
            color: var(--t3)
        }

        /* ═══ BADGES ═══ */
        .b {
            display: inline-flex;
            align-items: center;
            gap: .2rem;
            font-size: .6rem;
            font-weight: 700;
            padding: .15rem .4rem;
            border-radius: 4px;
            letter-spacing: .2px;
            line-height: 1.3
        }

        .b-green {
            background: var(--green-bg);
            color: #166534
        }

        .b-red {
            background: var(--red-bg);
            color: #991b1b
        }

        .b-yellow {
            background: var(--yellow-bg);
            color: #854d0e
        }

        .b-gray {
            background: var(--brd2);
            color: var(--t2)
        }

        .b-blue {
            background: var(--blue-bg);
            color: #1e40af
        }

        .b-rose {
            background: var(--pri-l);
            color: var(--pri-d)
        }

        .b-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            display: inline-block
        }

        .b-dot.on {
            background: var(--green)
        }

        .b-dot.off {
            background: var(--red)
        }

        /* ═══ BUTTONS ═══ */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: .25rem;
            font-size: .72rem;
            font-weight: 600;
            padding: .35rem .7rem;
            border-radius: var(--radius-sm);
            border: none;
            cursor: pointer;
            transition: all .12s;
            font-family: inherit;
            line-height: 1.3
        }

        .btn-pri {
            background: var(--dark);
            color: #fff
        }

        .btn-pri:hover {
            background: var(--pri-d)
        }

        .btn-rose {
            background: var(--pri-d);
            color: #fff
        }

        .btn-rose:hover {
            background: var(--dark)
        }

        .btn-out {
            background: var(--card);
            border: 1px solid var(--brd);
            color: var(--t2)
        }

        .btn-out:hover {
            border-color: var(--pri)
        }

        .btn-ghost {
            background: transparent;
            color: var(--t2);
            padding: .25rem .4rem
        }

        .btn-ghost:hover {
            background: var(--brd2);
            color: var(--t1)
        }

        .btn-red {
            background: var(--red-bg);
            color: #991b1b;
            border: 1px solid #fecaca
        }

        .btn-red:hover {
            background: var(--red);
            color: #fff;
            border-color: var(--red)
        }

        .btn-green {
            background: var(--green-bg);
            color: #166534;
            border: 1px solid #bbf7d0
        }

        .btn-green:hover {
            background: var(--green);
            color: #fff
        }

        .btn .mi {
            font-size: 14px
        }

        .btn-xs {
            padding: .2rem .4rem;
            font-size: .65rem
        }

        .btn-xs .mi {
            font-size: 12px
        }

        /* ═══ TOGGLE SWITCH ═══ */
        .tog {
            position: relative;
            width: 32px;
            height: 18px;
            display: inline-block
        }

        .tog input {
            opacity: 0;
            width: 0;
            height: 0
        }

        .tog .sl {
            position: absolute;
            inset: 0;
            background: var(--brd);
            border-radius: 9px;
            cursor: pointer;
            transition: .2s
        }

        .tog .sl:before {
            content: '';
            position: absolute;
            width: 14px;
            height: 14px;
            left: 2px;
            bottom: 2px;
            background: #fff;
            border-radius: 50%;
            transition: .2s;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .1)
        }

        .tog input:checked+.sl {
            background: var(--green)
        }

        .tog input:checked+.sl:before {
            transform: translateX(14px)
        }

        /* ═══ FORM ═══ */
        .form-card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--brd);
            margin-bottom: .75rem;
            overflow: hidden
        }

        .form-card-h {
            padding: .6rem 1rem;
            background: var(--bg);
            border-bottom: 1px solid var(--brd);
            font-size: .75rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: .3rem
        }

        .form-card-h .mi {
            font-size: 15px;
            color: var(--t3)
        }

        .form-card-b {
            padding: 1rem
        }

        .fg {
            margin-bottom: .75rem
        }

        .fg label {
            display: block;
            font-size: .68rem;
            font-weight: 600;
            margin-bottom: .25rem;
            color: var(--t2);
            text-transform: uppercase;
            letter-spacing: .5px
        }

        .fi {
            width: 100%;
            padding: .4rem .6rem;
            border: 1px solid var(--brd);
            border-radius: var(--radius-sm);
            font-size: .78rem;
            font-family: inherit;
            background: var(--card);
            transition: all .15s
        }

        .fi:focus {
            outline: none;
            border-color: var(--pri);
            box-shadow: 0 0 0 2px var(--pri-l)
        }

        textarea.fi {
            resize: vertical;
            min-height: 80px
        }

        select.fi {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='%23999'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right .5rem center
        }

        .fg-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .6rem
        }

        .fg-row-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: .6rem
        }

        .fg-check {
            display: flex;
            align-items: center;
            gap: .4rem
        }

        .fg-check input[type=checkbox] {
            width: 14px;
            height: 14px;
            accent-color: var(--pri-d)
        }

        .fg-check label {
            margin-bottom: 0;
            text-transform: none;
            font-size: .75rem
        }

        .fg .hint {
            font-size: .6rem;
            color: var(--t3);
            margin-top: .15rem
        }

        /* ═══ FILTER BAR ═══ */
        .filters {
            display: flex;
            align-items: center;
            gap: .5rem;
            padding: .5rem .75rem;
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--brd);
            margin-bottom: .75rem;
            flex-wrap: wrap
        }

        .filters .fi {
            flex: 1;
            min-width: 100px;
            font-size: .72rem;
            padding: .3rem .5rem
        }

        .filters .btn {
            flex-shrink: 0
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: .2rem;
            font-size: .6rem;
            font-weight: 600;
            padding: .2rem .5rem;
            border-radius: 20px;
            border: 1px solid var(--brd);
            color: var(--t2);
            cursor: pointer;
            transition: all .12s
        }

        .chip:hover,
        .chip.on {
            background: var(--pri-l);
            border-color: var(--pri);
            color: var(--pri-d)
        }

        /* ═══ PAGINATION ═══ */
        .pag {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .5rem 1rem;
            border-top: 1px solid var(--brd);
            font-size: .68rem;
            color: var(--t3)
        }

        .pag-btns {
            display: flex;
            gap: .2rem
        }

        .pag-btns a,
        .pag-btns span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 26px;
            height: 26px;
            border-radius: var(--radius-sm);
            font-size: .68rem;
            font-weight: 600;
            border: 1px solid var(--brd);
            color: var(--t2);
            transition: all .12s;
            padding: 0 .3rem
        }

        .pag-btns a:hover {
            border-color: var(--pri);
            color: var(--pri-d)
        }

        .pag-btns .cur {
            background: var(--dark);
            color: #fff;
            border-color: var(--dark)
        }

        .pag-btns .dis {
            opacity: .25;
            pointer-events: none
        }

        /* ═══ ALERT ═══ */
        .toast {
            position: fixed;
            top: calc(var(--top-h) + .5rem);
            right: 1.5rem;
            padding: .5rem 1rem;
            border-radius: var(--radius-sm);
            font-size: .75rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: .4rem;
            z-index: 200;
            animation: slideIn .3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .08)
        }

        .toast-ok {
            background: #166534;
            color: #fff
        }

        .toast-err {
            background: #991b1b;
            color: #fff
        }

        .toast .mi {
            font-size: 16px
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(20px)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        /* ═══ EMPTY ═══ */
        .empty-state {
            text-align: center;
            padding: 2.5rem 1rem
        }

        .empty-state .mi {
            font-size: 36px;
            color: var(--brd);
            margin-bottom: .5rem
        }

        .empty-state h3 {
            font-size: .85rem;
            font-weight: 600;
            margin-bottom: .2rem
        }

        .empty-state p {
            font-size: .72rem;
            color: var(--t3)
        }

        /* ═══ ACTIONS DROPDOWN ═══ */
        .act-group {
            display: flex;
            gap: .2rem;
            align-items: center
        }

        /* ═══ RESPONSIVE ═══ */
        @media(max-width:1024px) {
            .stats {
                grid-template-columns: repeat(2, 1fr)
            }

            .grid-2,
            .grid-3 {
                grid-template-columns: 1fr
            }
        }

        @media(max-width:768px) {
            .sb {
                transform: translateX(-100%)
            }

            .main {
                margin-left: 0
            }

            .fg-row,
            .fg-row-3 {
                grid-template-columns: 1fr
            }
        }
    </style>
    @yield('css')
</head>

<body>
    <aside class="sb">
        <div class="sb-top">
            <div class="logo-mark">EW</div>
            <div class="logo-text">Events<span>Wally</span></div>
        </div>
        <nav class="sb-nav">
            <div class="sb-label">Overview</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'on' : '' }}">
                <span class="mi material-icons-round">grid_view</span> Dashboard
            </a>

            <div class="sb-label">Manage</div>
            <a href="{{ route('admin.vendors.index') }}"
                class="{{ request()->routeIs('admin.vendors.*') ? 'on' : '' }}">
                <span class="mi material-icons-round">storefront</span> Vendors
                @php $vendorCount = \App\Models\Vendor::count(); @endphp
                @if($vendorCount)<span class="cnt">{{ $vendorCount }}</span>@endif
            </a>
            <a href="{{ route('admin.categories.index') }}"
                class="{{ request()->routeIs('admin.categories.*') ? 'on' : '' }}">
                <span class="mi material-icons-round">sell</span> Categories
            </a>
            <a href="{{ route('admin.cities.index') }}" class="{{ request()->routeIs('admin.cities.*') ? 'on' : '' }}">
                <span class="mi material-icons-round">apartment</span> Cities
            </a>

            <div class="sb-label">Other</div>
            <a href="{{ route('home') }}" target="_blank">
                <span class="mi material-icons-round">open_in_new</span> View Site
            </a>
        </nav>
        <div class="sb-ft">
            <div class="av">A</div>
            <div>
                <div class="n">Admin</div>
                <div class="r">Super Admin</div>
            </div>
        </div>
    </aside>

    <div class="main">
        <header class="topbar">
            <div class="topbar-l">
                <div class="crumb">
                    <a href="{{ route('admin.dashboard') }}">Admin</a>
                    <span class="sep">/</span>
                    <span>@yield('title', 'Dashboard')</span>
                </div>
            </div>
            <div class="topbar-r">
                <form method="POST" action="{{ route('admin.logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="tb-btn danger"><span class="mi material-icons-round">logout</span>
                        Exit</button>
                </form>
            </div>
        </header>

        <div class="content">
            @if(session('success'))
                <div class="toast toast-ok" id="toast"><span class="mi material-icons-round">check_circle</span>
                    {{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="toast toast-err" id="toast"><span class="mi material-icons-round">error</span>
                    {{ $errors->first() }}</div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        const t = document.getElementById('toast');
        if (t) setTimeout(() => { t.style.opacity = '0'; t.style.transform = 'translateX(20px)'; setTimeout(() => t.remove(), 300) }, 3500);
    </script>
    @yield('js')
</body>

</html>