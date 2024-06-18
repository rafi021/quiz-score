<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\QuizController;
use App\Http\Controllers\Api\V1\QuestionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Api\V1\QuestionResultController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


/*OAuth -- JWT */
Route::prefix('v1')
    ->middleware('guest')
    ->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
    });

Route::prefix('v1')
    ->middleware('auth:api')
    ->group(function () {
        Route::post('/logout', [AuthController::class, 'destroy']);
        // Route::middleware(['isAdmin'])->group(function () {
        Route::resource('quizzes', QuizController::class);
        Route::resource('questions', QuestionController::class);
        // });


        Route::post('/attend/{quizId}', [QuestionResultController::class, 'attendQuiz']);
        Route::get('/results/{quizId}', [QuestionResultController::class, 'getResults']);
    });

/*SPA -- Sanctum Token*/
Route::middleware('auth:sanctum')
    ->group(function () {

        // Route::middleware(['isAdmin'])->group(function () {
        Route::resource('quizzes', QuizController::class);
        Route::resource('questions', QuestionController::class);
        // });

        Route::post('/attend/{quizId}', [QuestionResultController::class, 'attendQuiz']);
        Route::get('/results/{quizId}', [QuestionResultController::class, 'getResults']);
    });
