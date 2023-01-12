<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\Incident_reportController;
use App\Http\Controllers\Api\Incident_report_commentController;
use App\Http\Controllers\Api\OrganizationController;
use App\Http\Controllers\Api\ImageController;


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


Route::middleware(['api'])->group(function () {
    //Auth
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/refresh', [AuthController::class, 'refresh']);
    
    // Event
    Route::apiResource('events', EventController::class);

    // Incident report
    Route::apiResource('incident/report', Incident_reportController::class);

    //Incident report comment
    Route::apiResource('incident/report/comment', Incident_report_commentController::class);
   
    // organization
    Route::apiResource('organizations', OrganizationController::class);

    // image
    Route::get('file/{path}', [ImageController::class, 'getImage'])->where('path', '.*');

});



