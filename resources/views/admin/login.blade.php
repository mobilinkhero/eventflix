<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login — EventsWally</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f4f3f1;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased
        }

        .login-card {
            background: #fff;
            border-radius: 16px;
            padding: 2.5rem;
            width: 100%;
            max-width: 380px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, .06);
            border: 1px solid #eeecea
        }

        .login-card h1 {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: .25rem;
            color: #1a1a1a
        }

        .login-card p {
            font-size: .84rem;
            color: #6b6b6b;
            margin-bottom: 1.75rem
        }

        .login-card .logo {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #2c2424;
            letter-spacing: -.3px
        }

        .login-card .logo span {
            color: #c48b8b
        }

        .fg {
            margin-bottom: 1.1rem
        }

        .fg label {
            display: block;
            font-size: .78rem;
            font-weight: 600;
            margin-bottom: .35rem;
            color: #6b6b6b
        }

        .fi {
            width: 100%;
            padding: .7rem .9rem;
            border: 1px solid #eeecea;
            border-radius: 8px;
            font-size: .86rem;
            font-family: inherit;
            background: #fff;
            transition: border-color .2s
        }

        .fi:focus {
            outline: none;
            border-color: #c48b8b
        }

        .btn {
            width: 100%;
            padding: .75rem;
            border: none;
            border-radius: 8px;
            font-size: .86rem;
            font-weight: 700;
            background: #2c2424;
            color: #fff;
            cursor: pointer;
            font-family: inherit;
            transition: background .2s
        }

        .btn:hover {
            background: #c48b8b
        }

        .err {
            font-size: .8rem;
            color: #c0392b;
            margin-bottom: 1rem;
            padding: .5rem .75rem;
            background: #fde3e1;
            border-radius: 6px
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="logo">Events<span>Wally</span></div>
        <h1>Admin Panel</h1>
        <p>Enter the admin password to continue.</p>

        @if($errors->any())
            <div class="err">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.authenticate') }}">
            @csrf
            <div class="fg">
                <label>Password</label>
                <input type="password" name="password" class="fi" placeholder="Enter admin password" autofocus required>
            </div>
            <button type="submit" class="btn">Sign In</button>
        </form>
    </div>
</body>

</html>