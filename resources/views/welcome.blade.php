<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    
    <div class="container text-center mt-5">
        <h1>Welcome to HealthTracker</h1>
        <p>Your health, our priority.</p>
        @if(Auth::check())
            <p>Hoş geldin, <strong>{{ Auth::user()->name }}</strong>!</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger">Çıkış Yap</button>
            </form>
        @else
            <a href="{{ route('loginAccount') }}" class="btn btn-primary">Login</a>
            <a href="{{ route('registerAccount') }}" class="btn btn-secondary">Register</a>
        @endif
    </div>
</body>
</html>