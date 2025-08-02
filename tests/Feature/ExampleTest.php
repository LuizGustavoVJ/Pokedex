<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // Testa se a API está funcionando
        $response = $this->get('/api/pokemon');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data',
                    'message'
                ]);
    }

    /**
     * Testa se a aplicação web está acessível
     */
    public function test_web_application_is_accessible(): void
    {
        $response = $this->get('/');

        // Verifica se retorna HTML (não necessariamente 200 se Vite não estiver rodando)
        $response->assertHeader('content-type', 'text/html; charset=UTF-8');
    }
}
