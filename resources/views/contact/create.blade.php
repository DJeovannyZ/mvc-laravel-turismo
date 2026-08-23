@extends('layouts.app')

@section('title', 'Contacto - Catalogo Turistico SV')

@section('container-class', 'form-container')

@section('content')
    <h1>Solicita mas informacion</h1>
    <p class="lead">Completa el formulario y un asesor te contactara con detalles del destino.</p>

    @if (session('success'))
        <div class="alert-success">&#10003; {{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert-errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="panel" method="POST" action="{{ route('contact.store') }}">
        @csrf

        <div class="field">
            <label for="nombre">Nombre completo</label>
            <input id="nombre" type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Ej. Maria Perez">
            @error('nombre') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label for="email">Correo electronico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="tucorreo@ejemplo.com">
            @error('email') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label for="lugar">Lugar de interes <small style="color:#94a3b8;">(opcional)</small></label>
            <select id="lugar" name="lugar">
                <option value="">-- Selecciona un destino --</option>
                @foreach ($places as $place)
                    <option value="{{ $place->slug }}" @selected(old('lugar', $selectedSlug) === $place->slug)>
                        {{ $place->titulo }} ({{ $place->departamento }})
                    </option>
                @endforeach
            </select>
            @error('lugar') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label for="mensaje">Mensaje</label>
            <textarea id="mensaje" name="mensaje" placeholder="Cuentanos que informacion necesitas: fechas, numero de personas, presupuesto...">{{ old('mensaje') }}</textarea>
            <small class="hint">Entre 10 y 500 caracteres.</small>
            @error('mensaje') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn btn-block" style="margin-top:0;">Enviar solicitud</button>
    </form>
@endsection
