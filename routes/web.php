<?php

use Illuminate\Support\Facades\Route;

// Rota principal que carrega o Vue.js
Route::get('/', function () {
    return view('app');
});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
