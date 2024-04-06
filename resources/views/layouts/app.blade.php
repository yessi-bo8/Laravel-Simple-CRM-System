<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <div class="upper-banner">
        <h1>Welcome to My Website</h1>
        <div class="toggle-menu" id="toggle-menu">View Options</div>
        <div class="menu-options">
            <ul>
                <li><a href="/projects">Projects</a></li>
                <li><a href="/clients">Clients</a></li>
                <li><a href="/account">My Account</a></li>
                <li><a href="/home">Home</a></li>
            </ul>
        </div>
    </div>


    <div class="content">
        @yield('content')
    </div>

    <footer>
        &copy; {{ date('Y') }} My Website
    </footer>

    
</body>
</html>
