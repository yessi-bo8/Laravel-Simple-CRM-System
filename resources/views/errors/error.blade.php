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
        <h1 id="banner-title">@yield('banner', 'Error Occurred')</h1>
        <a class="toggle-menu" id="toggle-menu">View Options</a>
        <div class="menu-options">
            <ul>
                <li><a href="/">Home</a></li>
            </ul>
        </div>
    </div>

    <div class="content">
        <div class="alert alert-error">
            <h2>Error</h2>
            <p>An error occurred while processing your request.</p>
            <p>{{ $message }} (Error {{ $statusCode }}).</p>
        </div>
    </div>

    <footer>
        &copy; {{ date('Y') }} My Website
    </footer>

</body>
</html>
