<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#07111b">
    <title>@yield('title', 'Gestor ADSO')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="app-shell">
        <header class="topbar">
            <a class="brand" href="{{ route('aprendices.index') }}">
                <span class="brand-mark">A</span>
                <span>GESTOR ADSO<small>PORTAL DE APRENDICES</small></span>
            </a>
            <div class="status"><span class="status-dot"></span> SISTEMA ACTIVO</div>
        </header>

        <main class="page-content">
            @if (session('ok'))
                <div class="flash">{{ session('ok') }}</div>
            @endif
            @yield('content')
        </main>

        <nav class="bottom-nav" aria-label="Navegación principal">
            <a href="{{ route('aprendices.index') }}" @if(request()->routeIs('aprendices.index')) aria-current="page" @endif>
                <span>▦</span>Aprendices
            </a>
            <a href="{{ route('aprendices.create') }}" @if(request()->routeIs('aprendices.create')) aria-current="page" @endif>
                <span>＋</span>Nuevo
            </a>
        </nav>
    </div>
</body>
</html>
