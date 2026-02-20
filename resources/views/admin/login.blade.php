<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — EventsWally</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #1e1b1b;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased
        }

        .wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem
        }

        .logo {
            display: flex;
            align-items: center;
            gap: .5rem;
            color: #fff
        }

        .logo-mark {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #b07272, #964f4f);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: .8rem;
            color: #fff
        }

        .logo-text {
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: -.3px
        }

        .logo-text span {
            color: #b07272;
            font-weight: 400
        }

        .card {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            width: 340px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .3)
        }

        .card h1 {
            font-size: 1rem;
            font-weight: 700;
            color: #111;
            margin-bottom: .15rem
        }

        .card p {
            font-size: .72rem;
            color: #999;
            margin-bottom: 1.25rem
        }

        .fg {
            margin-bottom: .85rem
        }

        .fg label {
            display: block;
            font-size: .68rem;
            font-weight: 600;
            margin-bottom: .25rem;
            color: #555;
            text-transform: uppercase;
            letter-spacing: .5px
        }

        .fi {
            width: 100%;
            padding: .5rem .7rem;
            border: 1px solid #ece9e6;
            border-radius: 6px;
            font-size: .82rem;
            font-family: inherit;
            transition: border-color .15s
        }

        .fi:focus {
            outline: none;
            border-color: #b07272;
            box-shadow: 0 0 0 2px #f5e6e6
        }

        .btn {
            width: 100%;
            padding: .55rem;
            border: none;
            border-radius: 6px;
            font-size: .78rem;
            font-weight: 700;
            background: #1e1b1b;
            color: #fff;
            cursor: pointer;
            font-family: inherit;
            transition: background .15s
        }

        .btn:hover {
            background: #b07272
        }

        .err {
            font-size: .72rem;
            color: #ef4444;
            margin-bottom: .75rem;
            padding: .4rem .6rem;
            background: #fee2e2;
            border-radius: 6px;
            border: 1px solid #fecaca
        }
    </style>
</head>

<body>
    <div class="wrap">
        <div class="logo">
            <div class="logo-mark">EW</div>
            <div class="logo-text">Events<span>Wally</span></div>
        </div>
        <div class="card">
            <h1>Admin Panel</h1>
            <p>Enter password to continue</p>

            @if($errors->any())
                <div class="err">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('admin.authenticate') }}">
                @csrf
                <div class="fg">
                    <label>Password</label>
                    <input type="password" name="password" class="fi" placeholder="••••••••" autofocus required>
                </div>
                <button type="submit" class="btn">Sign In →</button>
            </form>
        </div>
    </div>
</body>

</html>