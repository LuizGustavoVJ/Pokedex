<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PokemonController;

// Rotas de Pokémon (públicas)
Route::get('/pokemon', [PokemonController::class, 'index']);
Route::get('/pokemon/{name}', [PokemonController::class, 'show']);
Route::get('/pokemon-types', [PokemonController::class, 'types']);
