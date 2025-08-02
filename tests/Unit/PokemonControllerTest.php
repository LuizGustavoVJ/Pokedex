<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\API\PokemonController;
use App\Services\PokemonService;
use Illuminate\Http\Request;
use Mockery;

class PokemonControllerTest extends TestCase
{
    protected $controller;
    protected $mockService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockService = Mockery::mock(PokemonService::class);
        $this->app->instance(PokemonService::class, $this->mockService);
        $this->controller = new PokemonController($this->mockService);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Testa listagem de Pokémon com sucesso
     */
    public function test_index_returns_successful_response()
    {
        $mockData = [
            'pokemon' => [
                [
                    'id' => 1,
                    'name' => 'bulbasaur',
                    'height' => 70,
                    'weight' => 6.9,
                    'types' => ['grass', 'poison']
                ]
            ],
            'count' => 1,
            'next' => null,
            'previous' => null
        ];

        $this->mockService->shouldReceive('getAllPokemon')
            ->with(10, 0, null, null) // Valores padrão do controller
            ->once()
            ->andReturn($mockData);

        $request = Request::create('/api/pokemon', 'GET');
        $response = $this->controller->index($request);

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertTrue($data['success']);
        $this->assertEquals('Pokémon encontrados com sucesso', $data['message']);
        $this->assertEquals($mockData, $data['data']);
    }

    /**
     * Testa listagem com filtros
     */
    public function test_index_with_filters()
    {
        $mockData = [
            'pokemon' => [
                [
                    'id' => 25,
                    'name' => 'pikachu',
                    'height' => 40,
                    'weight' => 6.0,
                    'types' => ['electric']
                ]
            ],
            'count' => 1,
            'next' => null,
            'previous' => null
        ];

        $this->mockService->shouldReceive('getAllPokemon')
            ->with(10, 5, 'pikachu', 'electric')
            ->once()
            ->andReturn($mockData);

        $request = Request::create('/api/pokemon?limit=10&offset=5&name=pikachu&type=electric', 'GET');
        $response = $this->controller->index($request);

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertTrue($data['success']);
    }

    /**
     * Testa erro na listagem
     */
    public function test_index_returns_error_when_service_fails()
    {
        $this->mockService->shouldReceive('getAllPokemon')
            ->once()
            ->andReturn(null);

        $request = Request::create('/api/pokemon', 'GET');
        $response = $this->controller->index($request);

        $this->assertEquals(500, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('error', $data);
        $this->assertEquals('Erro ao buscar Pokémon', $data['error']);
    }

    /**
     * Testa busca de Pokémon específico com sucesso
     */
    public function test_show_returns_pokemon_details()
    {
        $mockPokemon = [
            'id' => 25,
            'name' => 'pikachu',
            'height' => 40,
            'weight' => 6.0,
            'types' => ['electric'],
            'abilities' => ['static', 'lightning-rod'],
            'stats' => [
                ['name' => 'hp', 'value' => 35]
            ],
            'sprites' => [
                'front_default' => 'https://example.com/front.png'
            ]
        ];

        $this->mockService->shouldReceive('getPokemonByName')
            ->with('pikachu')
            ->once()
            ->andReturn($mockPokemon);

        $response = $this->controller->show('pikachu');

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertTrue($data['success']);
        $this->assertEquals('Pokémon encontrado com sucesso', $data['message']);
        $this->assertEquals($mockPokemon, $data['data']);
    }

    /**
     * Testa Pokémon não encontrado
     */
    public function test_show_returns_404_when_pokemon_not_found()
    {
        $this->mockService->shouldReceive('getPokemonByName')
            ->with('invalid-pokemon')
            ->once()
            ->andReturn(null);

        $response = $this->controller->show('invalid-pokemon');

        $this->assertEquals(404, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('error', $data);
        $this->assertEquals('Pokémon não encontrado', $data['error']);
    }

    /**
     * Testa listagem de tipos
     */
    public function test_types_returns_pokemon_types()
    {
        $mockTypes = [
            ['id' => 'https://pokeapi.co/api/v2/type/1/', 'name' => 'normal'],
            ['id' => 'https://pokeapi.co/api/v2/type/10/', 'name' => 'fire'],
            ['id' => 'https://pokeapi.co/api/v2/type/11/', 'name' => 'water']
        ];

        $this->mockService->shouldReceive('getPokemonTypes')
            ->once()
            ->andReturn($mockTypes);

        $response = $this->controller->types();

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertTrue($data['success']);
        $this->assertEquals('Tipos de Pokémon carregados com sucesso', $data['message']);
        $this->assertEquals($mockTypes, $data['data']);
    }

    /**
     * Testa exceção no controller
     */
    public function test_controller_handles_exception()
    {
        $this->mockService->shouldReceive('getAllPokemon')
            ->once()
            ->andThrow(new \Exception('Test exception'));

        $request = Request::create('/api/pokemon', 'GET');
        $response = $this->controller->index($request);

        $this->assertEquals(500, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('error', $data);
        $this->assertEquals('Erro interno do servidor', $data['error']);
    }

    /**
     * Testa parâmetros padrão na listagem
     */
    public function test_index_uses_default_parameters()
    {
        $mockData = [
            'pokemon' => [],
            'count' => 0,
            'next' => null,
            'previous' => null
        ];

        $this->mockService->shouldReceive('getAllPokemon')
            ->with(10, 0, null, null) // Valores padrão corretos
            ->once()
            ->andReturn($mockData);

        $request = Request::create('/api/pokemon', 'GET');
        $response = $this->controller->index($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Testa parâmetros customizados na listagem
     */
    public function test_index_with_custom_parameters()
    {
        $mockData = [
            'pokemon' => [],
            'count' => 0,
            'next' => null,
            'previous' => null
        ];

        $this->mockService->shouldReceive('getAllPokemon')
            ->with(50, 100, 'charizard', 'fire') // Parâmetros customizados
            ->once()
            ->andReturn($mockData);

        $request = Request::create('/api/pokemon?limit=50&offset=100&name=charizard&type=fire', 'GET');
        $response = $this->controller->index($request);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
