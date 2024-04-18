<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="upper-banner">
        <h1>Welcome to My Website</h1>
        <div class="toggle-menu" id="toggle-menu">View Options</div>
        <div class="menu-options">
            <ul>
                <li><a href="/clients">Clients</a></li>
                <li><a href="/projects">Projects</a></li>
                <li><a href="/tasks">Tasks</a></li>
                <li><a href="/home">Home</a></li>
                @guest <!-- Show login and register links when user is not authenticated -->
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else <!-- Show logout link when user is authenticated -->
                <form id="logout-form" method="POST">
                    @csrf <!-- CSRF protection -->
                    <button type="button" id="logout-button">Logout</button>
                </form>
                <meta name="csrf-token" content="{{ csrf_token() }}">
                @endguest
            </ul>
        </div>
    </div>


    <div class="content">
    @if($errors->has('error'))
        <div class="alert alert-error">
            {{ $errors->first('error') }}
        </div>
    @elseif(session()->has('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif
        @yield('content')
    </div>

    <footer>
        &copy; {{ date('Y') }} My Website
    </footer>

    
</body>
</html>
