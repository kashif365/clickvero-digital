<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | Clickvora Digital</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/icon/favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome-pro.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    <style>
        body.admin-login-body {
            font-family: var(--admin-font);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%);
            margin: 0;
            padding: 20px;
        }

        .admin-login-card {
            width: 100%;
            max-width: 380px;
            background: #ffffff;
            border-radius: 14px;
            padding: 38px 32px;
            box-shadow: 0 20px 50px rgba(3, 10, 43, 0.35);
        }

        .admin-login-card img {
            height: 40px;
            display: block;
            margin: 0 auto 22px;
        }

        .admin-login-card h1 {
            font-size: 19px;
            font-weight: 700;
            color: var(--admin-heading);
            text-align: center;
            margin: 0 0 26px;
        }
    </style>
</head>

<body class="admin-login-body">
    <div class="admin-login-card">
        <span style="font-size:20px; font-weight:700; color:var(--admin-heading); display:block; text-align:center; margin-bottom:18px; letter-spacing:-.02em;">Clickvora <span style="color:#b88a00; font-weight:500;">Digital</span></span>
        <h1>Admin Sign In</h1>

        @if ($errors->any())
            <div class="admin-alert admin-alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="admin-form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="admin-form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="admin-form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="admin-form-control" required>
            </div>
            <button type="submit" class="admin-btn admin-btn-primary" style="width:100%; justify-content:center; padding:11px;">
                Sign In
            </button>
        </form>
    </div>
</body>

</html>
