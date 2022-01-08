<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    // our routes to be protected will go in here
    Route::prefix('posts')->group(function () {
        Route::get('/', [PostController::class, 'index']);
        Route::get('/{post:uuid}', [PostController::class, 'get']);
        Route::delete('/{post:uuid}', [PostController::class, 'destroy']);
        Route::patch('/{post:uuid}', [PostController::class, 'update']);
    });
});

Route::get('sendEmail', [PostController::class, 'sendEmail']);
