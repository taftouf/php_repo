<?php

namespace App\Http\Controllers\Api;

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

    // Questionnaire
    Route::apiResource('questionnaire', QuestionnaireController::class);

    // Answers
    Route::post('organization/{org_id}/user/{user_id}/answers', [AnswerController::class, 'set_user_answers']);
    Route::get('organization/{org_id}/user/{user_id}/answers', [AnswerController::class, 'get_user_answers']);

    // Framework
    Route::apiResource('framework', FrameworkController::class);

    // Control
    Route::apiResource('control', ControlController::class);

    // control_log
    Route::apiResource('log/control', Control_logController::class);

    // control_submission
    Route::apiResource('submission/control', Control_submissionController::class);

});



