<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $place->titulo }} - Catalogo Turistico</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f1f5f9; color: #0f172a; }
        header { background: #0f766e; color: #fff; padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; }
        header a { color: #fff; text-decoration: none; font-weight: 600; }
        main { max-width: 1000px; margin: 0 auto; padding: 2rem 1.5rem; }
        .hero img { width: 100%; height: 320px; object-fit: cover; border-radius: .75rem; }
        .badges { display: flex; gap: .5rem; margin-top: -1.25rem; padding-left: 1rem; position: relative; flex-wrap: wrap; }
        .badge { font-size: .75rem; font-weight: 700; padding: .3rem .8rem; border-radius: 999px; background: #ccfbf1; color: #115e59; text-transform: uppercase; letter-spacing: .04em; border: 2px solid #f1f5f9; }
        .badge.featured { background: #fef3c7; color: #92400e; }
        h1 { font-size: 1.9rem; margin: 1rem 0 .25rem; }
        .departamento { color: #64748b; font-size: 1rem; margin-bottom: 1.25rem; }
        .layout { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; align-items: start; }
        @media (max-width: 760px) { .layout { grid-template-columns: 1fr; } }
        section.panel, aside.panel { background: #fff; border-radius: .75rem; padding: 1.25rem 1.5rem; box-shadow: 0 1px 3px rgba(15,23,42,.12); }
        h3 { font-size: .85rem; text-transform: uppercase; letter-spacing: .05em; color: #64748b; margin-bottom: .75rem; }
        .descripcion { line-height: 1.65; color: #334155; }
        .servicios { list-style: none; display: flex; flex-wrap: wrap; gap: .5rem; margin-top: 1.25rem; }
        .servicios li { background: #f0fdfa; border: 1px solid #99f6e4; color: #115e59; padding: .35rem .8rem; border-radius: .5rem; font-size: .85rem; }
        .precio-row { display: flex; justify-content: space-between; padding: .6rem 0; border-bottom: 1px solid #e2e8f0; font-size: .95rem; }
        .precio-row:last-of-type { border-bottom: none; }
        .precio-row strong { color: #0f766e; font-size: 1.05rem; }
        .nota { font-size: .8rem; color: #94a3b8; margin-top: .75rem; }
        aside .btn { display: block; text-align: center; background: #0f766e; color: #fff; text-decoration: none; padding: .7rem; border-radius: .5rem; font-weight: 600; margin-top: 1rem; }
        aside .btn:hover { background: #115e59; }
        .relacionados { margin-top: 2.5rem; }
        .relacionados-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1rem; }
        .mini-card { background: #fff; border-radius: .6rem; overflow: hidden; box-shadow: 0 1px 3px rgba(15,23,42,.12); text-decoration: none; color: inherit; transition: transform .15s ease; }
        .mini-card:hover { transform: translateY(-3px); }
        .mini-card img { width: 100%; height: 110px; object-fit: cover; }
        .mini-card div { padding: .7rem .9rem; }
        .mini-card strong { font-size: .92rem; }
        .mini-card span { display: block; color: #64748b; font-size: .8rem; margin-top: .15rem; }
    </style>
</head>
<body>
    <header>
        <a href="{{ route('places.index') }}">&larr; Catalogo Turistico SV</a>
    </header>

    <main>
        <div class="hero"><img src="{{ $place->imagen }}" alt="{{ $place->titulo }}"></div>

        <div class="badges">
            <span class="badge">{{ $place->categoria }}</span>
            @if ($place->destacado)
                <span class="badge featured">Destacado</span>
            @endif
        </div>

        <h1>{{ $place->titulo }}</h1>
        <p class="departamento">&#128205; {{ $place->departamento }}</p>

        <div class="layout">
            <section class="panel">
                <h3>Sobre este destino</h3>
                <p class="descripcion">{{ $place->descripcion }}</p>
                @if ($place->servicios)
                    <h3 style="margin-top: 1.5rem;">Servicios disponibles</h3>
                    <ul class="servicios">
                        @foreach ($place->servicios as $servicio)
                            <li>{{ $servicio }}</li>
                        @endforeach
                    </ul>
                @endif
            </section>

            <aside class="panel">
                <h3>Precios</h3>
                <div class="precio-row">
                    <span>Entrada</span>
                    <strong>@if ($place->hasFreeEntry()) Gratuita @else {{ Number::currency($place->precioEntrada, 'USD') }} @endif</strong>
                </div>
                <div class="precio-row">
                    <span>Tour guiado</span>
                    <strong>{{ Number::currency($place->precioTour, 'USD') }}</strong>
                </div>
                <p class="nota">Precios de referencia por persona en dolares (USD).</p>
                <a class="btn" href="{{ route('contact.create', ['lugar' => $place->slug]) }}">Solicitar informacion</a>
            </aside>
        </div>

        @if ($related->isNotEmpty())
            <div class="relacionados">
                <h3>Tambien en {{ $place->categoria }}</h3>
                <div class="relacionados-grid">
                    @foreach ($related as $item)
                        <a class="mini-card" href="{{ route('places.show', $item->slug) }}">
                            <img src="{{ $item->imagen }}" alt="{{ $item->titulo }}">
                            <div>
                                <strong>{{ $item->titulo }}</strong>
                                <span>{{ $item->departamento }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </main>
</body>
</html>
