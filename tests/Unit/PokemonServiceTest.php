<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\PokemonService;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PokemonServiceTest extends TestCase
{
    protected $pokemonService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pokemonService = new PokemonService();
    }

    /**
     * Testa conversão de altura de decímetros para centímetros
     */
    public function test_convert_height_to_cm()
    {
        // Usando reflection para acessar método protegido
        $reflection = new \ReflectionClass($this->pokemonService);
        $method = $reflection->getMethod('convertHeightToCm');
        $method->setAccessible(true);

        // Teste com diferentes valores
        $this->assertEquals(40, $method->invoke($this->pokemonService, 4));  // 4 dm = 40 cm
        $this->assertEquals(70, $method->invoke($this->pokemonService, 7));  // 7 dm = 70 cm
        $this->assertEquals(0, $method->invoke($this->pokemonService, 0));   // 0 dm = 0 cm
        $this->assertEquals(100, $method->invoke($this->pokemonService, 10)); // 10 dm = 100 cm
    }

    /**
     * Testa conversão de peso de hectogramas para quilogramas
     */
    public function test_convert_weight_to_kg()
    {
        // Usando reflection para acessar método protegido
        $reflection = new \ReflectionClass($this->pokemonService);
        $method = $reflection->getMethod('convertWeightToKg');
        $method->setAccessible(true);

        // Teste com diferentes valores
        $this->assertEquals(6.0, $method->invoke($this->pokemonService, 60));   // 60 hg = 6.0 kg
        $this->assertEquals(9.0, $method->invoke($this->pokemonService, 90));   // 90 hg = 9.0 kg
        $this->assertEquals(0.0, $method->invoke($this->pokemonService, 0));    // 0 hg = 0.0 kg
        $this->assertEquals(90.5, $method->invoke($this->pokemonService, 905)); // 905 hg = 90.5 kg
    }

    /**
     * Testa formatação de dados do Pokémon
     */
    public function test_format_pokemon_data()
    {
        // Dados mock de um Pokémon
        $mockPokemonData = [
            'id' => 25,
            'name' => 'pikachu',
            'height' => 4,  // 4 decímetros
            'weight' => 60, // 60 hectogramas
            'types' => [
                ['type' => ['name' => 'electric']]
            ],
            'abilities' => [
                ['ability' => ['name' => 'static']],
                ['ability' => ['name' => 'lightning-rod']]
            ],
            'stats' => [
                ['stat' => ['name' => 'hp'], 'base_stat' => 35],
                ['stat' => ['name' => 'attack'], 'base_stat' => 55]
            ],
            'sprites' => [
                'front_default' => 'https://example.com/front.png',
                'back_default' => 'https://example.com/back.png',
                'front_shiny' => 'https://example.com/front-shiny.png',
                'back_shiny' => 'https://example.com/back-shiny.png'
            ]
        ];

        // Usando reflection para acessar método protegido
        $reflection = new \ReflectionClass($this->pokemonService);
        $method = $reflection->getMethod('formatPokemonData');
        $method->setAccessible(true);

        $formattedData = $method->invoke($this->pokemonService, $mockPokemonData);

        // Verificações
        $this->assertEquals(25, $formattedData['id']);
        $this->assertEquals('pikachu', $formattedData['name']);
        $this->assertEquals(40, $formattedData['height']); // 4 dm = 40 cm
        $this->assertEquals(6.0, $formattedData['weight']); // 60 hg = 6.0 kg
        $this->assertEquals(['electric'], $formattedData['types']);
        $this->assertEquals(['static', 'lightning-rod'], $formattedData['abilities']);
        $this->assertCount(2, $formattedData['stats']);
        $this->assertEquals('hp', $formattedData['stats'][0]['name']);
        $this->assertEquals(35, $formattedData['stats'][0]['value']);
        $this->assertArrayHasKey('front_default', $formattedData['sprites']);
        $this->assertArrayHasKey('back_default', $formattedData['sprites']);
    }

    /**
     * Testa busca de Pokémon por nome com mock
     */
    public function test_get_pokemon_by_name_with_mock()
    {
        // Mock da resposta da API
        Http::fake([
            'https://pokeapi.co/api/v2/pokemon/pikachu' => Http::response([
                'id' => 25,
                'name' => 'pikachu',
                'height' => 4,
                'weight' => 60,
                'types' => [
                    ['type' => ['name' => 'electric']]
                ],
                'abilities' => [
                    ['ability' => ['name' => 'static']]
                ],
                'stats' => [
                    ['stat' => ['name' => 'hp'], 'base_stat' => 35]
                ],
                'sprites' => [
                    'front_default' => 'https://example.com/front.png',
                    'back_default' => null,
                    'front_shiny' => null,
                    'back_shiny' => null
                ]
            ], 200)
        ]);

        $result = $this->pokemonService->getPokemonByName('pikachu');

        $this->assertNotNull($result);
        $this->assertEquals(25, $result['id']);
        $this->assertEquals('pikachu', $result['name']);
        $this->assertEquals(40, $result['height']); // Convertido para cm
        $this->assertEquals(6.0, $result['weight']); // Convertido para kg
        $this->assertEquals(['electric'], $result['types']);
    }

    /**
     * Testa busca de Pokémon por nome inexistente
     */
    public function test_get_pokemon_by_name_not_found()
    {
        Http::fake([
            'https://pokeapi.co/api/v2/pokemon/invalid-pokemon' => Http::response([], 404)
        ]);

        $result = $this->pokemonService->getPokemonByName('invalid-pokemon');

        $this->assertNull($result);
    }

    /**
     * Testa busca de tipos de Pokémon
     */
    public function test_get_pokemon_types()
    {
        Http::fake([
            'https://pokeapi.co/api/v2/type' => Http::response([
                'results' => [
                    ['name' => 'normal', 'url' => 'https://pokeapi.co/api/v2/type/1/'],
                    ['name' => 'fire', 'url' => 'https://pokeapi.co/api/v2/type/10/'],
                    ['name' => 'water', 'url' => 'https://pokeapi.co/api/v2/type/11/']
                ]
            ], 200)
        ]);

        $types = $this->pokemonService->getPokemonTypes();

        $this->assertIsArray($types);
        $this->assertCount(3, $types);
        $this->assertEquals('normal', $types[0]['name']);
        $this->assertEquals('fire', $types[1]['name']);
        $this->assertEquals('water', $types[2]['name']);
    }

    /**
     * Testa busca de tipos quando API falha
     */
    public function test_get_pokemon_types_api_error()
    {
        Http::fake([
            'https://pokeapi.co/api/v2/type' => Http::response([], 500)
        ]);

        $types = $this->pokemonService->getPokemonTypes();

        $this->assertIsArray($types);
        $this->assertEmpty($types);
    }

    /**
     * Testa timeout na requisição HTTP
     */
    public function test_http_timeout_handling()
    {
        Http::fake([
            'https://pokeapi.co/api/v2/pokemon/pikachu' => Http::response([], 408)
        ]);

        $result = $this->pokemonService->getPokemonByName('pikachu');

        $this->assertNull($result);
    }

    /**
     * Testa conversão de unidades com valores extremos
     */
    public function test_extreme_unit_conversion_values()
    {
        $reflection = new \ReflectionClass($this->pokemonService);
        $heightMethod = $reflection->getMethod('convertHeightToCm');
        $weightMethod = $reflection->getMethod('convertWeightToKg');
        $heightMethod->setAccessible(true);
        $weightMethod->setAccessible(true);

        // Valores extremos para altura
        $this->assertEquals(0, $heightMethod->invoke($this->pokemonService, 0));
        $this->assertEquals(1000, $heightMethod->invoke($this->pokemonService, 100));
        $this->assertEquals(-100, $heightMethod->invoke($this->pokemonService, -10));

        // Valores extremos para peso
        $this->assertEquals(0.0, $weightMethod->invoke($this->pokemonService, 0));
        $this->assertEquals(999.9, $weightMethod->invoke($this->pokemonService, 9999));
        $this->assertEquals(-10.0, $weightMethod->invoke($this->pokemonService, -100));
    }
}
