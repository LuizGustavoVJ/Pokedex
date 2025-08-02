<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class PokemonService
{
    private $baseUrl = 'https://pokeapi.co/api/v2';

    /**
     * Fetch the initial list of Pokemons based on type.
     */
    public function getInitialPokemonList($type)
    {
        if ($type) {
            $typeResponse = Http::get("{$this->baseUrl}/type/{$type}");
            if (!$typeResponse->successful()) {
                return [];
            }

            return collect($typeResponse->json()['pokemon'])
                ->pluck('pokemon')
                ->toArray();
        }

        $response = Http::get("{$this->baseUrl}/pokemon", ['limit' => 100]);
        if (!$response->successful()) {
            return [];
        }

        return $response->json()['results'] ?? [];
    }

    /**
     * Fetch detailed information about a specific Pokemon.
     */
    public function getPokemonDetails($name)
    {
        $response = Http::get("{$this->baseUrl}/pokemon/{$name}");
        if (!$response->successful()) {
            return null;
        }

        $data = $response->json();

        // Extract types
        $types = collect($data['types'])->pluck('type.name')->toArray();

        /// Convert from decimeters to centimeters
        $heightCm = $data['height'] * 10;
        // Convert from hectograms to kilograms
        $weightKg = $data['weight'] / 10;

        return [
            'id' => $data['id'],
            'name' => $data['name'],
            'height' => $heightCm,
            'weight' => $weightKg,
            'types' => $types,
        ];
    }
}
