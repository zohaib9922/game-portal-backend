<?php

use Illuminate\Support\Facades\Route;
use App\Models\Game;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/game-proxy/{game}', function (Game $game) {
    $response = Http::withHeaders([
        'Referer' => 'https://gamedistribution.com',
        'Origin'  => 'https://gamedistribution.com',
    ])->get($game->embed_url);

    return response($response->body(), 200)
        ->header('Content-Type', 'text/html')
        ->header('X-Frame-Options', 'ALLOWALL');
});