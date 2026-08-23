@extends('layouts.app')

@section('title', $place->titulo.' - Catalogo Turistico SV')

@section('content')
    <div class="detail-hero">
        <img src="{{ $place->imagen }}" alt="{{ $place->titulo }}">
    </div>

    <div class="badges" style="margin-top: 1rem;">
        <span class="badge">{{ $place->categoria }}</span>
        @if ($place->destacado)
            <span class="badge featured">Destacado</span>
        @endif
    </div>

    <h1 class="detail-title">{{ $place->titulo }}</h1>
    <p class="departamento" style="margin-bottom: 1.25rem;">&#128205; {{ $place->departamento }}</p>

    <div class="detail-layout">
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
            <a class="btn btn-block" href="{{ route('contact.create', ['lugar' => $place->slug]) }}">Solicitar informacion</a>
        </aside>
    </div>

    @if ($related->isNotEmpty())
        <div class="related">
            <h3 style="font-size:.85rem;text-transform:uppercase;letter-spacing:.05em;color:#64748b;margin-bottom:.75rem;">
                Tambien en {{ $place->categoria }}
            </h3>
            <div class="related-grid">
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
@endsection
