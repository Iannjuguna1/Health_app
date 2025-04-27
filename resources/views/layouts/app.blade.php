<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Health App')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Include CSS -->
</head>
<body>
    <header>
        <nav>
            <a href="/">Home</a>
            <a href="/clients">Clients</a>
            <a href="/programs">Programs</a>
        </nav>
    </header>
    <main>
        @yield('content') <!-- Section for page-specific content -->
    </main>
    <footer>
        <p>&copy; {{ date('Y') }} Health App</p>
    </footer>
</body>
</html>
