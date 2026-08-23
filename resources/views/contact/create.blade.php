<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Catalogo Turistico SV</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f1f5f9; color: #0f172a; }
        header { background: #0f766e; color: #fff; padding: 1rem 1.5rem; }
        header a { color: #fff; text-decoration: none; font-weight: 600; }
        main { max-width: 640px; margin: 0 auto; padding: 2rem 1.5rem; }
        h1 { font-size: 1.7rem; margin-bottom: .35rem; }
        .lead { color: #64748b; margin-bottom: 1.5rem; }
        .alert-success { background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: .9rem 1.1rem; border-radius: .6rem; margin-bottom: 1.25rem; }
        form, .errors-box { background: #fff; border-radius: .75rem; padding: 1.5rem 1.75rem; box-shadow: 0 1px 3px rgba(15,23,42,.12); }
        .field { margin-bottom: 1.15rem; }
        label { display: block; font-weight: 600; font-size: .9rem; margin-bottom: .4rem; }
        input, select, textarea { width: 100%; padding: .65rem .8rem; border: 1px solid #cbd5e1; border-radius: .5rem; font-size: .95rem; font-family: inherit; background: #fff; }
        input:focus, select:focus, textarea:focus { outline: 2px solid #0f766e; border-color: transparent; }
        textarea { min-height: 130px; resize: vertical; }
        small.hint { display: block; color: #94a3b8; margin-top: .3rem; font-size: .78rem; }
        .error-text { color: #b91c1c; font-size: .82rem; margin-top: .35rem; }
        button { width: 100%; background: #0f766e; color: #fff; border: none; padding: .8rem; font-size: 1rem; font-weight: 700; border-radius: .55rem; cursor: pointer; }
        button:hover { background: #115e59; }
        .errors-box ul { list-style: none; }
        .errors-box li { color: #b91c1c; padding: .2rem 0; }
    </style>
</head>
<body>
    <header>
        <a href="{{ route('places.index') }}">&larr; Catalogo Turistico SV</a>
    </header>

    <main>
        <h1>Solicita mas informacion</h1>
        <p class="lead">Completa el formulario y un asesor te contactara con detalles del destino.</p>

        @if (session('success'))
            <div class="alert-success">&#10003; {{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="errors-box" style="margin-bottom: 1.25rem;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('contact.store') }}">
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

            <button type="submit">Enviar solicitud</button>
        </form>
    </main>
</body>
</html>
