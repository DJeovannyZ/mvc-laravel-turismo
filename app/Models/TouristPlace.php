<?php

namespace App\Models;

use InvalidArgumentException;

class TouristPlace
{
    public readonly int $id;

    public readonly string $slug;

    public readonly string $titulo;

    public readonly string $departamento;

    public readonly string $categoria;

    public readonly string $descripcion;

    public readonly float $precioEntrada;

    public readonly float $precioTour;

    /**
     * @param  list<string>  $servicios
     */
    public readonly array $servicios;

    public readonly string $imagen;

    public readonly bool $destacado;

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        foreach (['id', 'slug', 'titulo', 'departamento', 'categoria', 'descripcion', 'imagen'] as $required) {
            if (! isset($data[$required]) || ($data[$required] === '')) {
                throw new InvalidArgumentException("El lugar turistico no define el campo requerido [{$required}].");
            }
        }

        $place = new self;
        $place->id = (int) $data['id'];
        $place->slug = (string) $data['slug'];
        $place->titulo = (string) $data['titulo'];
        $place->departamento = (string) $data['departamento'];
        $place->categoria = (string) $data['categoria'];
        $place->descripcion = (string) $data['descripcion'];
        $place->precioEntrada = max(0.0, (float) ($data['precio_entrada'] ?? 0));
        $place->precioTour = max(0.0, (float) ($data['precio_tour'] ?? 0));
        $place->servicios = array_values((array) ($data['servicios'] ?? []));
        $place->imagen = (string) $data['imagen'];
        $place->destacado = (bool) ($data['destacado'] ?? false);

        return $place;
    }

    public function precioDesde(): float
    {
        if ($this->precioEntrada > 0 && $this->precioTour > 0) {
            return min($this->precioEntrada, $this->precioTour);
        }

        return max($this->precioEntrada, $this->precioTour);
    }

    public function hasFreeEntry(): bool
    {
        return $this->precioEntrada === 0.0;
    }
}
