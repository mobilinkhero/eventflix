<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — EventsWally</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        :root {
            --pri: #c48b8b;
            --pri-d: #ad7070;
            --pri-l: #f5e6e6;
            --bg: #f4f3f1;
            --card: #fff;
            --dark: #2c2424;
            --t1: #1a1a1a;
            --t2: #6b6b6b;
            --t3: #a0a0a0;
            --brd: #eeecea;
            --green: #34c759;
            --red: #ff3b30;
            --gold: #ffb800;
            --sb-w: 240px;
        }

        html {
            scroll-behavior: smooth
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--t1);
            -webkit-font-smoothing: antialiased;
            display: flex;
            min-height: 100vh
        }

        a {
            color: inherit;
            text-decoration: none
        }

        /* ═══ SIDEBAR ═══ */
        .sb {
            width: var(--sb-w);
            background: var(--dark);
            color: #fff;
            padding: 0;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            z-index: 10
        }

        .sb-logo {
            padding: 1.25rem 1.5rem;
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: -.3px;
            border-bottom: 1px solid rgba(255, 255, 255, .08)
        }

        .sb-logo span {
            color: var(--pri)
        }

        .sb-nav {
            flex: 1;
            padding: .75rem 0;
            overflow-y: auto
        }

        .sb-nav a {
            display: flex;
            align-items: center;
            gap: .65rem;
            padding: .6rem 1.5rem;
            font-size: .82rem;
            font-weight: 500;
            color: rgba(255, 255, 255, .55);
            transition: all .15s
        }

        .sb-nav a:hover {
            color: #fff;
            background: rgba(255, 255, 255, .06)
        }

        .sb-nav a.on {
            color: #fff;
            background: rgba(255, 255, 255, .1);
            border-right: 3px solid var(--pri)
        }

        .sb-nav a .mi {
            font-size: 20px
        }

        .sb-nav .sep {
            height: 1px;
            background: rgba(255, 255, 255, .06);
            margin: .5rem 1.5rem
        }

        .sb-ft {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, .06);
            font-size: .72rem;
            color: rgba(255, 255, 255, .3)
        }

        /* ═══ MAIN ═══ */
        .main {
            margin-left: var(--sb-w);
            flex: 1;
            min-height: 100vh
        }

        .topbar {
            background: var(--card);
            padding: .75rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--brd);
            position: sticky;
            top: 0;
            z-index: 5
        }

        .topbar h1 {
            font-size: 1.15rem;
            font-weight: 700
        }

        .topbar-r {
            display: flex;
            align-items: center;
            gap: 1rem
        }

        .topbar-r form button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: .8rem;
            font-weight: 600;
            color: var(--t2);
            display: flex;
            align-items: center;
            gap: .3rem;
            font-family: inherit
        }

        .topbar-r form button:hover {
            color: var(--red)
        }

        .content {
            padding: 1.75rem 2rem
        }

        /* ═══ STATS ═══ */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.75rem
        }

        .stat {
            background: var(--card);
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            border: 1px solid var(--brd)
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: .75rem
        }

        .stat-icon .mi {
            font-size: 22px;
            color: #fff
        }

        .stat h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: .15rem
        }

        .stat p {
            font-size: .78rem;
            color: var(--t2)
        }

        /* ═══ TABLE ═══ */
        .tbl-wrap {
            background: var(--card);
            border-radius: 12px;
            border: 1px solid var(--brd);
            overflow: hidden;
            margin-bottom: 1.5rem
        }

        .tbl-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--brd)
        }

        .tbl-head h2 {
            font-size: .95rem;
            font-weight: 700
        }

        .tbl {
            width: 100%;
            border-collapse: collapse
        }

        .tbl th {
            text-align: left;
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: var(--t3);
            padding: .7rem 1.25rem;
            background: #fafaf8;
            border-bottom: 1px solid var(--brd)
        }

        .tbl td {
            padding: .75rem 1.25rem;
            font-size: .84rem;
            border-bottom: 1px solid var(--brd);
            vertical-align: middle
        }

        .tbl tr:last-child td {
            border-bottom: none
        }

        .tbl tr:hover td {
            background: #fdfcfa
        }

        /* ═══ BADGES ═══ */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: .25rem;
            font-size: .68rem;
            font-weight: 700;
            padding: .2rem .55rem;
            border-radius: 6px;
            letter-spacing: .2px
        }

        .badge-green {
            background: #dcf5e3;
            color: #1a7a32
        }

        .badge-red {
            background: #fde3e1;
            color: #c0392b
        }

        .badge-yellow {
            background: #fff4d6;
            color: #8a6d00
        }

        .badge-gray {
            background: #f0efed;
            color: var(--t2)
        }

        .badge-rose {
            background: var(--pri-l);
            color: var(--pri-d)
        }

        /* ═══ BUTTONS ═══ */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            font-size: .8rem;
            font-weight: 600;
            padding: .5rem 1rem;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all .15s;
            font-family: inherit
        }

        .btn-pri {
            background: var(--pri-d);
            color: #fff
        }

        .btn-pri:hover {
            background: var(--dark)
        }

        .btn-out {
            background: transparent;
            border: 1px solid var(--brd);
            color: var(--t2)
        }

        .btn-out:hover {
            border-color: var(--pri);
            color: var(--pri-d)
        }

        .btn-red {
            background: #fde3e1;
            color: #c0392b
        }

        .btn-red:hover {
            background: #c0392b;
            color: #fff
        }

        .btn-sm {
            padding: .35rem .7rem;
            font-size: .75rem
        }

        .btn .mi {
            font-size: 16px
        }

        /* ═══ FORM ═══ */
        .form-card {
            background: var(--card);
            border-radius: 12px;
            border: 1px solid var(--brd);
            padding: 1.75rem;
            margin-bottom: 1.5rem
        }

        .form-card h2 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
            padding-bottom: .75rem;
            border-bottom: 1px solid var(--brd)
        }

        .fg {
            margin-bottom: 1.1rem
        }

        .fg label {
            display: block;
            font-size: .78rem;
            font-weight: 600;
            margin-bottom: .35rem;
            color: var(--t2)
        }

        .fi {
            width: 100%;
            padding: .6rem .85rem;
            border: 1px solid var(--brd);
            border-radius: 8px;
            font-size: .84rem;
            font-family: inherit;
            background: var(--card);
            transition: border-color .2s
        }

        .fi:focus {
            outline: none;
            border-color: var(--pri)
        }

        textarea.fi {
            resize: vertical;
            min-height: 100px
        }

        select.fi {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='%23a0a0a0'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right .75rem center
        }

        .fg-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem
        }

        .fg-check {
            display: flex;
            align-items: center;
            gap: .5rem
        }

        .fg-check input[type=checkbox] {
            width: 16px;
            height: 16px;
            accent-color: var(--pri-d)
        }

        .fg-check label {
            margin-bottom: 0
        }

        /* ═══ FILTER BAR ═══ */
        .filters {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: 1rem 1.5rem;
            background: var(--card);
            border-radius: 12px;
            border: 1px solid var(--brd);
            margin-bottom: 1.25rem;
            flex-wrap: wrap
        }

        .filters .fi {
            width: auto;
            flex: 1;
            min-width: 140px
        }

        .filters .btn {
            flex-shrink: 0
        }

        /* ═══ PAGINATION ═══ */
        .pag {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .3rem;
            padding: 1rem
        }

        .pag a,
        .pag span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 .5rem;
            border-radius: 6px;
            font-size: .78rem;
            font-weight: 500;
            border: 1px solid var(--brd);
            color: var(--t2);
            transition: all .15s
        }

        .pag a:hover {
            border-color: var(--pri);
            color: var(--pri-d)
        }

        .pag .cur {
            background: var(--dark);
            color: #fff;
            border-color: var(--dark)
        }

        .pag .dis {
            opacity: .3;
            pointer-events: none
        }

        /* ═══ ALERT ═══ */
        .alert {
            padding: .75rem 1.25rem;
            border-radius: 8px;
            font-size: .84rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: .5rem
        }

        .alert-ok {
            background: #dcf5e3;
            color: #1a7a32;
            border: 1px solid #b8e6c4
        }

        .alert-err {
            background: #fde3e1;
            color: #c0392b;
            border: 1px solid #f5c6c2
        }

        @media(max-width:768px) {
            .sb {
                width: 0;
                overflow: hidden
            }

            .main {
                margin-left: 0
            }

            .stats {
                grid-template-columns: repeat(2, 1fr)
            }

            .fg-row {
                grid-template-columns: 1fr
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sb">
        <div class="sb-logo">Events<span>Wally</span> Admin</div>
        <nav class="sb-nav">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'on' : '' }}">
                <span class="mi material-icons-round">dashboard</span> Dashboard
            </a>
            <div class="sep"></div>
            <a href="{{ route('admin.vendors.index') }}"
                class="{{ request()->routeIs('admin.vendors.*') ? 'on' : '' }}">
                <span class="mi material-icons-round">store</span> Vendors
            </a>
            <a href="{{ route('admin.categories.index') }}"
                class="{{ request()->routeIs('admin.categories.*') ? 'on' : '' }}">
                <span class="mi material-icons-round">category</span> Categories
            </a>
            <a href="{{ route('admin.cities.index') }}" class="{{ request()->routeIs('admin.cities.*') ? 'on' : '' }}">
                <span class="mi material-icons-round">location_city</span> Cities
            </a>
            <div class="sep"></div>
            <a href="{{ route('home') }}" target="_blank">
                <span class="mi material-icons-round">language</span> View Website
            </a>
        </nav>
        <div class="sb-ft">EventsWally v1.0</div>
    </aside>

    <!-- Main Content -->
    <div class="main">
        <header class="topbar">
            <h1>@yield('title', 'Dashboard')</h1>
            <div class="topbar-r">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"><span class="mi material-icons-round" style="font-size:16px">logout</span>
                        Logout</button>
                </form>
            </div>
        </header>

        <div class="content">
            @if(session('success'))
                <div class="alert alert-ok"><span class="mi material-icons-round" style="font-size:18px">check_circle</span>
                    {{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-err">
                    <span class="mi material-icons-round" style="font-size:18px">error</span>
                    {{ $errors->first() }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>

</html>