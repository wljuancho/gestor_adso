@extends('layouts.app')

@section('title', 'Nuevo aprendiz | Gestor ADSO')

@section('content')
    <a class="back-link" href="{{ route('aprendices.index') }}"><span aria-hidden="true">←</span> Volver al listado</a>
    <div class="eyebrow">GESTIÓN ACADÉMICA · ADSO</div>
    <div class="page-heading">
        <div>
            <h1>Nuevo aprendiz</h1>
            <p class="subheading">Completa los datos para registrar una persona.</p>
        </div>
    </div>

    <div class="form-layout">
        <section class="form-panel">
            <div class="form-heading">
                <h1>Datos de registro</h1>
                <p class="subheading">Los campos marcados son obligatorios.</p>
            </div>

            @if ($errors->any())
                <div class="error-box" role="alert">
                    <strong>No se pudo completar el registro:</strong>
                    <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('aprendices.store') }}" method="POST">
                @csrf
                <div class="form-fields">
                    <div>
                        <label class="field-label" for="nombre">Nombre completo</label>
                        <input class="field-input" id="nombre" name="nombre" value="{{ old('nombre') }}" maxlength="120" autocomplete="name" required placeholder="Ej. Juana Pérez">
                        @error('nombre')<small class="field-error">{{ $message }}</small>@enderror
                    </div>
                    <div>
                        <label class="field-label" for="documento">Número de documento</label>
                        <input class="field-input" id="documento" name="documento" value="{{ old('documento') }}" maxlength="40" required placeholder="Número de identificación">
                        @error('documento')<small class="field-error">{{ $message }}</small>@enderror
                    </div>
                    <div>
                        <label class="field-label" for="correo">Correo electrónico</label>
                        <input class="field-input" type="email" id="correo" name="correo" value="{{ old('correo') }}" maxlength="120" autocomplete="email" required placeholder="nombre@correo.com">
                        @error('correo')<small class="field-error">{{ $message }}</small>@enderror
                    </div>
                    <div>
                        <label class="field-label" for="ficha_id">Número de ficha <span style="color:#8ca1b2;font-weight:400">(opcional)</span></label>
                        <input class="field-input" type="number" id="ficha_id" name="ficha_id" value="{{ old('ficha_id') }}" placeholder="Ej. 2847561">
                        @error('ficha_id')<small class="field-error">{{ $message }}</small>@enderror
                    </div>
                </div>
                <div class="form-actions">
                    <button class="button" type="submit">Guardar aprendiz</button>
                    <a class="button button-secondary" href="{{ route('aprendices.index') }}">Cancelar</a>
                </div>
            </form>
        </section>

        <aside class="visual-panel" aria-label="Animación de cubo tridimensional">
            <div class="orbit" aria-hidden="true"></div>
            <div class="cube-stage" aria-hidden="true">
                <div class="cube">
                    <span class="cube-face front"></span><span class="cube-face back"></span>
                    <span class="cube-face right"></span><span class="cube-face left"></span>
                    <span class="cube-face top"></span><span class="cube-face bottom"></span>
                </div>
            </div>
            <div class="visual-caption">GESTIÓN DE APRENDICES · ADSO</div>
        </aside>
    </div>
@endsection
