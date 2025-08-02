<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\PokemonService;
use Mockery;

class PokemonTest extends TestCase
{
    /**
     * Teste para listar Pokémon
     */
    public function test_can_list_pokemon()
    {
        $response = $this->get('/api/pokemon');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        'pokemon',
                        'count',
                        'next',
                        'previous'
                    ],
                    'message'
                ]);
    }

    /**
     * Teste para buscar Pokémon por nome
     */
    public function test_can_search_pokemon_by_name()
    {
        $response = $this->get('/api/pokemon?name=pikachu');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        'pokemon',
                        'count',
                        'next',
                        'previous'
                    ],
                    'message'
                ]);
    }

    /**
     * Teste para filtrar Pokémon por tipo
     */
    public function test_can_filter_pokemon_by_type()
    {
        $response = $this->get('/api/pokemon?type=fire');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        'pokemon',
                        'count',
                        'type'
                    ],
                    'message'
                ]);
    }

    /**
     * Teste para buscar detalhes de um Pokémon específico
     */
    public function test_can_get_pokemon_details()
    {
        $response = $this->get('/api/pokemon/pikachu');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        'id',
                        'name',
                        'height',
                        'weight',
                        'types',
                        'abilities',
                        'stats',
                        'sprites'
                    ],
                    'message'
                ]);
    }

    /**
     * Teste para buscar tipos de Pokémon
     */
    public function test_can_get_pokemon_types()
    {
        $response = $this->get('/api/pokemon-types');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data',
                    'message'
                ]);
    }

    /**
     * Teste para Pokémon não encontrado
     */
    public function test_returns_404_for_invalid_pokemon()
    {
        $response = $this->get('/api/pokemon/invalid-pokemon-name');

        $response->assertStatus(404)
                ->assertJsonStructure([
                    'error',
                    'message'
                ]);
    }

    /**
     * Teste para conversão de unidades
     */
    public function test_unit_conversion()
    {
        $response = $this->get('/api/pokemon/pikachu');

        $response->assertStatus(200);

        $pokemon = $response->json('data');

        // Verificar se altura está em centímetros (número)
        $this->assertIsNumeric($pokemon['height']);
        $this->assertGreaterThan(0, $pokemon['height']);

        // Verificar se peso está em quilogramas (número)
        $this->assertIsNumeric($pokemon['weight']);
        $this->assertGreaterThan(0, $pokemon['weight']);
    }

    /**
     * Teste para estrutura de dados do Pokémon
     */
    public function test_pokemon_data_structure()
    {
        $response = $this->get('/api/pokemon/pikachu');

        $response->assertStatus(200);

        $pokemon = $response->json('data');

        // Verificar campos obrigatórios
        $this->assertArrayHasKey('id', $pokemon);
        $this->assertArrayHasKey('name', $pokemon);
        $this->assertArrayHasKey('height', $pokemon);
        $this->assertArrayHasKey('weight', $pokemon);
        $this->assertArrayHasKey('types', $pokemon);
        $this->assertArrayHasKey('abilities', $pokemon);
        $this->assertArrayHasKey('stats', $pokemon);
        $this->assertArrayHasKey('sprites', $pokemon);

        // Verificar se types é um array
        $this->assertIsArray($pokemon['types']);

        // Verificar se stats é um array
        $this->assertIsArray($pokemon['stats']);

        // Verificar se abilities é um array
        $this->assertIsArray($pokemon['abilities']);

        // Verificar estrutura dos sprites
        $this->assertArrayHasKey('front_default', $pokemon['sprites']);
        $this->assertArrayHasKey('back_default', $pokemon['sprites']);
        $this->assertArrayHasKey('front_shiny', $pokemon['sprites']);
        $this->assertArrayHasKey('back_shiny', $pokemon['sprites']);
    }

    /**
     * Teste para paginação
     */
    public function test_pagination()
    {
        $response = $this->get('/api/pokemon?limit=5&offset=0');

        $response->assertStatus(200);

        $data = $response->json('data');

        // Verificar se retornou no máximo 5 Pokémon
        $this->assertLessThanOrEqual(5, count($data['pokemon']));
    }

    /**
     * Teste para parâmetros de paginação
     */
    public function test_pagination_parameters()
    {
        $response = $this->get('/api/pokemon?limit=10&offset=20');

        $response->assertStatus(200);

        $data = $response->json('data');

        // Verificar se retornou no máximo 10 Pokémon
        $this->assertLessThanOrEqual(10, count($data['pokemon']));
    }

    /**
     * Teste para filtro por nome com resultado único
     */
    public function test_search_by_name_returns_single_result()
    {
        $response = $this->get('/api/pokemon?name=charizard');

        $response->assertStatus(200);

        $data = $response->json('data');

        // Quando busca por nome específico, deve retornar apenas 1 resultado
        $this->assertEquals(1, $data['count']);
        $this->assertCount(1, $data['pokemon']);
    }

    /**
     * Teste para filtro por tipo
     */
    public function test_filter_by_type()
    {
        $response = $this->get('/api/pokemon?type=water');

        $response->assertStatus(200);

        $data = $response->json('data');

        // Verificar se todos os Pokémon retornados são do tipo especificado
        foreach ($data['pokemon'] as $pokemon) {
            $this->assertContains('water', $pokemon['types']);
        }
    }

    /**
     * Teste para estrutura de tipos de Pokémon
     */
    public function test_pokemon_types_structure()
    {
        $response = $this->get('/api/pokemon-types');

        $response->assertStatus(200);

        $types = $response->json('data');

        // Verificar se é um array
        $this->assertIsArray($types);

        // Verificar estrutura de cada tipo
        if (count($types) > 0) {
            $firstType = $types[0];
            $this->assertArrayHasKey('id', $firstType);
            $this->assertArrayHasKey('name', $firstType);
        }
    }

    /**
     * Teste para erro de conexão com API externa
     */
    public function test_handles_external_api_error()
    {
        // Mock do service para simular erro
        $this->mock(PokemonService::class, function ($mock) {
            $mock->shouldReceive('getAllPokemon')
                 ->andReturn(null);
        });

        $response = $this->get('/api/pokemon');

        $response->assertStatus(500)
                ->assertJsonStructure([
                    'error',
                    'message'
                ]);
    }

    /**
     * Teste para erro ao buscar Pokémon específico
     */
    public function test_handles_pokemon_not_found_error()
    {
        // Mock do service para simular Pokémon não encontrado
        $this->mock(PokemonService::class, function ($mock) {
            $mock->shouldReceive('getPokemonByName')
                 ->andReturn(null);
        });

        $response = $this->get('/api/pokemon/non-existent-pokemon');

        $response->assertStatus(404)
                ->assertJsonStructure([
                    'error',
                    'message'
                ]);
    }
}
