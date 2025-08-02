<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Teste básico de exemplo
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }

    /**
     * Teste de matemática básica
     */
    public function test_basic_math(): void
    {
        $this->assertEquals(4, 2 + 2);
        $this->assertEquals(10, 5 * 2);
        $this->assertEquals(3, 9 / 3);
    }

    /**
     * Teste de arrays
     */
    public function test_array_operations(): void
    {
        $array = [1, 2, 3, 4, 5];

        $this->assertCount(5, $array);
        $this->assertContains(3, $array);
        $this->assertEquals(1, $array[0]);
        $this->assertEquals(5, $array[4]);
    }

    /**
     * Teste de strings
     */
    public function test_string_operations(): void
    {
        $name = 'Pokemon';

        $this->assertEquals('Pokemon', $name);
        $this->assertEquals(7, strlen($name));
        $this->assertEquals('POKEMON', strtoupper($name));
        $this->assertEquals('pokemon', strtolower($name));
    }

    /**
     * Teste de lógica condicional
     */
    public function test_conditional_logic(): void
    {
        $age = 25;

        $this->assertTrue($age > 18);
        $this->assertFalse($age < 18);
        $this->assertTrue($age >= 25);
        $this->assertTrue($age <= 30);
    }

    /**
     * Teste de objetos
     */
    public function test_object_creation(): void
    {
        $pokemon = new \stdClass();
        $pokemon->name = 'Pikachu';
        $pokemon->type = 'Electric';
        $pokemon->height = 40;

        $this->assertEquals('Pikachu', $pokemon->name);
        $this->assertEquals('Electric', $pokemon->type);
        $this->assertEquals(40, $pokemon->height);
        $this->assertIsObject($pokemon);
    }
}
