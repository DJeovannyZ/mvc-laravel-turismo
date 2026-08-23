@extends('layouts.app')

@section('title', 'Catalogo Turistico de El Salvador')

@section('hero')
    <section class="page-hero">
        <h1>Descubre El Salvador</h1>
        <p>Catalogo de lugares turisticos &middot; {{ $places->count() }} destinos disponibles</p>
    </section>
@endsection

@section('content')
    <div class="grid-places">
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
@endsection
