<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\PokemonService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PokemonController extends Controller
{
    protected $pokemonService;

    public function __construct(PokemonService $pokemonService)
    {
        $this->pokemonService = $pokemonService;
    }

    /**
     * Lista todos os Pokémon com filtros
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $limit = $request->input('limit', 10);
            $offset = $request->input('offset', 0);
            $name = $request->input('name');
            $type = $request->input('type');

            $result = $this->pokemonService->getAllPokemon($limit, $offset, $name, $type);

            if (!$result) {
                return response()->json([
                    'error' => 'Erro ao buscar Pokémon',
                    'message' => 'Não foi possível conectar com a PokeAPI'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'data' => $result,
                'message' => 'Pokémon encontrados com sucesso'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro interno do servidor',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Retorna detalhes de um Pokémon específico
     */
    public function show($name): JsonResponse
    {
        try {
            $pokemonData = $this->pokemonService->getPokemonByName($name);

            if (!$pokemonData) {
                return response()->json([
                    'error' => 'Pokémon não encontrado',
                    'message' => "O Pokémon '{$name}' não foi encontrado"
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $pokemonData,
                'message' => 'Pokémon encontrado com sucesso'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro interno do servidor',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Retorna tipos de Pokémon disponíveis
     */
    public function types(): JsonResponse
    {
        $types = $this->pokemonService->getPokemonTypes();

        return response()->json([
            'success' => true,
            'data' => $types,
            'message' => 'Tipos de Pokémon carregados com sucesso'
        ]);
    }
}
