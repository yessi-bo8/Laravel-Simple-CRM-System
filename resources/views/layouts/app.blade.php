<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
    <link rel="stylesheet" href="/css/app.css">
    @vite(['resources/js/app.js'])
</head>

<body>
    <div class="upper-banner">
    <h1 id="banner-title">@yield('banner', 'Welcome to My Website')</h1>
        <a class="toggle-menu" id="toggle-menu">View Options</a>
        <div class="menu-options">
            <ul>
            @auth
                @can('index', App\Models\Client::class)
                <li><a href="/clients">Clients</a></li>
                @endcan
                <li><a href="/projects">Projects</a></li>
                <li><a href="/tasks">Tasks</a></li>
            @endauth
                @guest <!-- Show login and register links when user is not authenticated -->
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else <!-- Show logout link when user is authenticated -->
                <li>
                    <form id="logout-form" method="POST">
                    @csrf <!-- CSRF protection -->
                        <button type="button" id="logout-button">Logout</button>
                    </form>
                </li>
                @endguest
            </ul>
        </div>
    </div>

    <div class="content">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @yield('content')
    </div>

    <footer>
        &copy; {{ date('Y') }} My Website
    </footer>

    
</body>
</html>
