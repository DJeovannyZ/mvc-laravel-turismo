<?php

namespace App\Http\Controllers;

use App\Repositories\TouristPlaceRepository;
use Illuminate\Contracts\View\View;

class PlaceController extends Controller
{
    public function __construct(
        private readonly TouristPlaceRepository $places
    ) {}

    public function index(): View
    {
        return view('places.index', [
            'places' => $this->places->all(),
            'featured' => $this->places->featured(),
        ]);
    }

    public function show(string $slug): View
    {
        $place = $this->places->findBySlug($slug);

        abort_unless($place !== null, 404, "El lugar turistico [$slug] no existe en el catalogo.");

        return view('places.show', [
            'place' => $place,
            'related' => $this->places->all()
                ->reject(fn ($candidate) => $candidate->slug === $place->slug)
                ->filter(fn ($candidate) => $candidate->categoria === $place->categoria)
                ->values(),
        ]);
    }
}
