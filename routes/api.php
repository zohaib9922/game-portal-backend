<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| All routes return JSON. CORS is handled via config/cors.php.
| Set FRONTEND_URL in .env to your React dev/prod URL.
*/

Route::prefix('games')->group(function () {
    Route::get('/',            [GameController::class, 'index']);
    Route::get('/featured',    [GameController::class, 'featured']);
    Route::get('/categories',  [GameController::class, 'categories']);
    Route::get('/{game}',      [GameController::class, 'show']);
    Route::post('/',           [GameController::class, 'store']);
    Route::put('/{game}',      [GameController::class, 'update']);
    Route::delete('/{game}',   [GameController::class, 'destroy']);
    Route::post('/{game}/play',[GameController::class, 'play']);
});
