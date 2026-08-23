<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo Turistico de El Salvador</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f1f5f9; color: #0f172a; }
        header { background: #0f766e; color: #fff; padding: 2.5rem 1.5rem; text-align: center; }
        header h1 { font-size: 2rem; }
        header p { opacity: .85; margin-top: .5rem; }
        main { max-width: 1200px; margin: 0 auto; padding: 2rem 1.5rem; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
        .card { background: #fff; border-radius: .75rem; overflow: hidden; box-shadow: 0 1px 3px rgba(15,23,42,.12); transition: transform .15s ease, box-shadow .15s ease; }
        .card:hover { transform: translateY(-4px); box-shadow: 0 8px 20px rgba(15,23,42,.16); }
        .card img { width: 100%; height: 175px; object-fit: cover; display: block; }
        .card-body { padding: 1rem 1.25rem 1.25rem; }
        .badges { display: flex; gap: .5rem; flex-wrap: wrap; margin-bottom: .5rem; }
        .badge { font-size: .72rem; font-weight: 600; padding: .2rem .6rem; border-radius: 999px; background: #ccfbf1; color: #115e59; text-transform: uppercase; letter-spacing: .03em; }
        .badge.featured { background: #fef3c7; color: #92400e; }
        h2 { font-size: 1.15rem; margin-bottom: .35rem; }
        .departamento { color: #64748b; font-size: .9rem; display: flex; align-items: center; gap: .35rem; }
        .card-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; padding-top: .85rem; border-top: 1px solid #e2e8f0; }
        .precio { font-weight: 700; color: #0f766e; }
        .precio small { color: #94a3b8; font-weight: 400; }
        .btn { background: #0f766e; color: #fff; text-decoration: none; padding: .45rem 1rem; border-radius: .5rem; font-size: .88rem; font-weight: 600; }
        .btn:hover { background: #115e59; }
        footer { text-align: center; padding: 2rem; color: #94a3b8; font-size: .85rem; }
    </style>
</head>
<body>
    <header>
        <h1>Descubre El Salvador</h1>
        <p>Catalogo de lugares turisticos &middot; {{ $places->count() }} destinos disponibles</p>
    </header>

    <main>
        <div class="grid">
            @foreach ($places as $place)
                <article class="card">
                    <img src="{{ $place->imagen }}" alt="{{ $place->titulo }}">
                    <div class="card-body">
                        <div class="badges">
                            <span class="badge">{{ $place->categoria }}</span>
                            @if ($place->destacado)
                                <span class="badge featured">Destacado</span>
                            @endif
                        </div>
                        <h2>{{ $place->titulo }}</h2>
                        <p class="departamento">&#128205; {{ $place->departamento }}</p>
                        <div class="card-footer">
                            <span class="precio">
                                @if ($place->hasFreeEntry())
                                    Entrada gratuita
                                @else
                                    Desde {{ Number::currency($place->precioDesde(), 'USD') }}
                                @endif
                                <small>/ persona</small>
                            </span>
                            <a class="btn" href="{{ route('places.show', $place->slug) }}">Ver detalle</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </main>

    <footer>Implementacion del patron MVC en Laravel &middot; Kodigo PHP</footer>
</body>
</html>
