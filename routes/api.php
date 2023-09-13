<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\AuthController;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    
    Route::post('logout', [AuthController::class, 'logout']);
    
    Route::resource('customers', CustomerController::class);
    Route::post('customers/{customer}/attachPrograms', [CustomerController::class, 'attachPrograms']);
    Route::post('customers/{customer}/detachPrograms', [CustomerController::class, 'detachPrograms']);
    
    Route::resource('exercises', ExerciseController::class);
    
    Route::resource('programs', ProgramController::class);
    Route::post('programs/{program}/attachExercises', [ProgramController::class, 'attachExercises']);
    Route::post('programs/{program}/detachExercises', [ProgramController::class, 'detachExercises']);
});

