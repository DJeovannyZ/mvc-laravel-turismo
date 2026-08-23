<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Catalogo Turistico SV')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="{{ route('places.index') }}">&#127956;&#65039; Catalogo Turistico SV</a>
            <nav class="site-nav">
                <a href="{{ route('places.index') }}" @if (request()->routeIs('places.index')) class="active" @endif>Inicio</a>
                <a href="{{ route('contact.create') }}" @if (request()->routeIs('contact.*')) class="active" @endif>Contacto</a>
            </nav>
        </div>
    </header>

    @hasSection('hero')
        @yield('hero')
    @endif

    <main class="container @yield('container-class')">
        @yield('content')
    </main>

    <footer class="site-footer">
        Implementacion del patron MVC en Laravel &middot; Kodigo PHP &middot; {{ date('Y') }}
    </footer>
</body>
</html>
