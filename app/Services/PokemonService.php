<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PokemonService
{
    protected $baseUrl = 'https://pokeapi.co/api/v2';

    /**
     * Busca todos os Pokémon com filtros
     */
    public function getAllPokemon($limit = 20, $offset = 0, $name = null, $type = null)
    {
        try {
            // Se tem filtro por nome, busca direto
            if ($name) {
                $pokemon = $this->getPokemonByName($name);
                return $pokemon ? [
                    'pokemon' => [$pokemon],
                    'count' => 1,
                    'next' => null,
                    'previous' => null
                ] : null;
            }

            // Se tem filtro por tipo, busca por tipo
            if ($type) {
                return $this->getPokemonByType($type, $limit, $offset);
            }

            // Busca lista geral
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 30
            ])->get("{$this->baseUrl}/pokemon", [
                'limit' => $limit,
                'offset' => $offset
            ]);

            if (!$response->successful()) {
                return null;
            }

            $data = $response->json();
            $pokemonList = [];

            foreach ($data['results'] as $pokemon) {
                $pokemonData = $this->getPokemonDetails($pokemon['url']);
                if ($pokemonData) {
                    $pokemonList[] = $pokemonData;
                }
            }

            return [
                'pokemon' => $pokemonList,
                'count' => $data['count'],
                'next' => $data['next'],
                'previous' => $data['previous']
            ];

        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Busca Pokémon por nome
     */
    public function getPokemonByName($name)
    {
        try {
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 30
            ])->get("{$this->baseUrl}/pokemon/{$name}");

            if (!$response->successful()) {
                return null;
            }

            return $this->formatPokemonData($response->json());

        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Busca Pokémon por tipo
     */
    public function getPokemonByType($type, $limit = 20, $offset = 0)
    {
        try {
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 30
            ])->get("{$this->baseUrl}/type/{$type}");

            if (!$response->successful()) {
                return null;
            }

            $data = $response->json();
            $pokemonList = [];

            // Pega apenas os Pokémon do tipo especificado
            $pokemonEntries = array_slice($data['pokemon'], $offset, $limit);

            foreach ($pokemonEntries as $entry) {
                $pokemonData = $this->getPokemonDetails($entry['pokemon']['url']);
                if ($pokemonData) {
                    $pokemonList[] = $pokemonData;
                }
            }

            return [
                'pokemon' => $pokemonList,
                'count' => count($data['pokemon']),
                'type' => $type
            ];

        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Busca detalhes de um Pokémon pela URL
     */
    protected function getPokemonDetails($url)
    {
        try {
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 30
            ])->get($url);

            if (!$response->successful()) {
                return null;
            }

            return $this->formatPokemonData($response->json());

        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Formata os dados do Pokémon
     */
    protected function formatPokemonData($pokemonData)
    {
        return [
            'id' => $pokemonData['id'],
            'name' => $pokemonData['name'],
            'height' => $this->convertHeightToCm($pokemonData['height']),
            'weight' => $this->convertWeightToKg($pokemonData['weight']),
            'types' => array_map(function($type) {
                return $type['type']['name'];
            }, $pokemonData['types']),
            'abilities' => array_map(function($ability) {
                return $ability['ability']['name'];
            }, $pokemonData['abilities']),
            'stats' => array_map(function($stat) {
                return [
                    'name' => $stat['stat']['name'],
                    'value' => $stat['base_stat']
                ];
            }, $pokemonData['stats']),
            'sprites' => [
                'front_default' => $pokemonData['sprites']['front_default'],
                'back_default' => $pokemonData['sprites']['back_default'],
                'front_shiny' => $pokemonData['sprites']['front_shiny'],
                'back_shiny' => $pokemonData['sprites']['back_shiny']
            ]
        ];
    }

    /**
     * Converte altura de decímetros para centímetros
     */
    protected function convertHeightToCm($heightInDecimeters)
    {
        return $heightInDecimeters * 10; // 1 decímetro = 10 centímetros
    }

    /**
     * Converte peso de hectogramas para quilogramas
     */
    protected function convertWeightToKg($weightInHectograms)
    {
        return $weightInHectograms / 10; // 1 hectograma = 0.1 quilogramas
    }

    /**
     * Retorna tipos de Pokémon disponíveis
     */
    public function getPokemonTypes()
    {
        try {
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 30
            ])->get("{$this->baseUrl}/type");

            if (!$response->successful()) {
                return [];
            }

            $data = $response->json();

            return array_map(function($type) {
                return [
                    'id' => $type['url'],
                    'name' => $type['name']
                ];
            }, $data['results']);

        } catch (\Exception $e) {
            return [];
        }
    }
}
