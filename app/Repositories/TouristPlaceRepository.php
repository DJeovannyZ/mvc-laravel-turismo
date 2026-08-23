<?php

namespace App\Repositories;

use App\Models\TouristPlace;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use RuntimeException;

class TouristPlaceRepository
{
    private readonly string $dataPath;

    public function __construct(?string $dataPath = null)
    {
        $this->dataPath = $dataPath !== null && $dataPath !== ''
            ? $dataPath
            : storage_path('app/data/lugares.json');
    }

    /**
     * @return Collection<int, TouristPlace>
     */
    public function all(): Collection
    {
        return collect($this->rawPlaces())
            ->map(fn (array $data): TouristPlace => TouristPlace::fromArray($data))
            ->values();
    }

    /**
     * @return Collection<int, TouristPlace>
     */
    public function featured(): Collection
    {
        return $this->all()->filter(fn (TouristPlace $place): bool => $place->destacado)->values();
    }

    public function findBySlug(string $slug): ?TouristPlace
    {
        return $this->all()->first(fn (TouristPlace $place): bool => $place->slug === $slug);
    }

    public function categories(): Collection
    {
        return $this->all()
            ->map(fn (TouristPlace $place): string => $place->categoria)
            ->unique()
            ->sort()
            ->values();
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function rawPlaces(): array
    {
        if (! File::exists($this->dataPath)) {
            throw new RuntimeException("El archivo de datos [{$this->dataPath}] no existe.");
        }

        $decoded = json_decode(File::get($this->dataPath), true);

        if (! is_array($decoded)) {
            throw new RuntimeException("El archivo de datos [{$this->dataPath}] no contiene JSON valido.");
        }

        return $decoded;
    }
}
