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
}
