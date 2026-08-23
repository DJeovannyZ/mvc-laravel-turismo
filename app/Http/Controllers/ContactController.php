<?php

namespace App\Http\Controllers;

use App\Repositories\TouristPlaceRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function __construct(
        private readonly TouristPlaceRepository $places
    ) {}

    public function create(Request $request): View
    {
        return view('contact.create', [
            'places' => $this->places->all(),
            'selectedSlug' => $request->query('lugar'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'min:3', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'lugar' => ['nullable', 'string', Rule::in($this->places->all()->pluck('slug')->all())],
            'mensaje' => ['required', 'string', 'min:10', 'max:500'],
        ], [
            'nombre.required' => 'Tu nombre es obligatorio.',
            'nombre.min' => 'Tu nombre debe tener al menos :min caracteres.',
            'email.required' => 'El correo electronico es obligatorio.',
            'email.email' => 'Ingresa un correo electronico valido.',
            'lugar.in' => 'El lugar seleccionado no pertenece al catalogo.',
            'mensaje.required' => 'El mensaje es obligatorio.',
            'mensaje.min' => 'El mensaje debe tener al menos :min caracteres.',
            'mensaje.max' => 'El mensaje no puede exceder :max caracteres.',
        ]);

        return redirect()
            ->route('contact.create')
            ->withInput()
            ->with('success', "Gracias {$validated['nombre']}, tu solicitud fue registrada. Te responderemos a la brevedad.");
    }
}
