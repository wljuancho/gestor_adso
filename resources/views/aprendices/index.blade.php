@extends('layouts.app')

@section('title', 'Aprendices | Gestor ADSO')

@section('content')
    <span id="inicio-listado"></span>
    <div class="eyebrow">GESTIÓN ACADÉMICA · ADSO</div>
    <section class="three-hero" data-three-hero aria-label="Animación 3D de Gestor ADSO">
        <div class="three-canvas" data-three-canvas aria-hidden="true"></div>
        <div class="hero-scrim" aria-hidden="true"></div>
        <div class="hero-hud">
            <div class="hero-topline">
                <span class="hero-chip"><span class="hero-pulse"></span> PHP · LARAVEL · MYSQL</span>
                <span class="hero-chip hero-count">{{ $totalAprendices }} registrados</span>
            </div>
            <div class="hero-copy">
                <div class="hero-title">Portal de Aprendices <span>v1.0</span></div>
                <p>Gestión académica sincronizada con la base de datos.</p>
            </div>
        </div>
    </section>
    <div class="page-heading">
        <div>
            <h1>Aprendices</h1>
            <p class="subheading">Consulta y administra los aprendices registrados.</p>
        </div>
        <a class="button" href="{{ route('aprendices.create') }}"><span>＋</span> Nuevo aprendiz</a>
    </div>

    <section class="stats-grid" aria-label="Resumen">
        <article class="stat-card"><div class="stat-label">Aprendices registrados</div><div class="stat-value">{{ $totalAprendices }}</div></article>
        <article class="stat-card"><div class="stat-label">Resultados encontrados</div><div class="stat-value" data-filtered-total>{{ $aprendices->total() }}</div></article>
        <article class="stat-card"><div class="stat-label">Estado del sistema</div><div class="stat-value" style="color:#39e8bc">Activo</div></article>
    </section>

    <section class="search-panel" aria-label="Búsqueda de aprendices">
        <form class="search-form search-form-wide" action="{{ route('aprendices.index') }}" method="GET" role="search" data-live-search>
            <input class="search-input" type="search" name="buscar" value="{{ $busqueda }}" placeholder="Escribe un nombre, documento o correo..." aria-label="Buscar por nombre, documento o correo" autocomplete="off">
            <button class="search-button" type="submit">Buscar</button>
            @if ($busqueda)
                <a class="clear-search" href="{{ route('aprendices.index') }}" aria-label="Limpiar búsqueda">Limpiar</a>
            @endif
        </form>
        <p class="search-feedback" data-search-feedback aria-live="polite">{{ $busqueda ? $aprendices->total() . ' resultado(s)' : 'Los resultados aparecerán mientras escribes.' }}</p>
    </section>

    <section class="panel">
        <div class="toolbar">
            <h2>Directorio de formación</h2>
            <span class="result-count">{{ $aprendices->total() }} resultado(s)</span>
        </div>

        <div class="learner-list">
            @forelse ($aprendices as $aprendiz)
                <article class="learner-card">
                    <div class="avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($aprendiz->nombre, 0, 1)) }}</div>
                    <div class="learner-main">
                        <div class="learner-name">{{ $aprendiz->nombre }}</div>
                        <div class="learner-meta">
                            <span>CC {{ $aprendiz->documento }}</span>
                            <span class="learner-email">{{ $aprendiz->correo }}</span>
                        </div>
                    </div>
                    <span class="badge">Aprendiz</span>
                </article>
            @empty
                <div class="empty-state">
                    {{ $busqueda ? 'No se encontraron aprendices con esa búsqueda.' : 'Aún no hay aprendices registrados.' }}
                </div>
            @endforelse
        </div>

        @if ($aprendices->hasPages())
            <nav class="pagination" aria-label="Paginación">
                @if ($aprendices->onFirstPage())
                    <span class="disabled">← Anterior</span>
                @else
                    <a href="{{ $aprendices->previousPageUrl() }}">← Anterior</a>
                @endif
                <span>Página {{ $aprendices->currentPage() }} de {{ $aprendices->lastPage() }}</span>
                @if ($aprendices->hasMorePages())
                    <a href="{{ $aprendices->nextPageUrl() }}">Siguiente →</a>
                @else
                    <span class="disabled">Siguiente →</span>
                @endif
            </nav>
        @endif
    </section>
    <a class="back-to-top" href="#inicio-listado" aria-label="Volver al inicio del listado" title="Volver arriba">↑</a>
@endsection
