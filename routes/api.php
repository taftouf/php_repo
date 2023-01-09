<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;


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

// Public Route
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
// Route::get('/users', [UserController::class, 'getUsers']);
//Private Route

Route::middleware(['auth:sanctum'])->group(function () {
    
});

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/users/profile', function () {
        return "test";
    });
});

