<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ProgramController;
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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('customers', CustomerController::class);
Route::post('customers/attachProgram', [CustomerController::class, 'attachProgram']);
Route::post('customers/detachProgram', [CustomerController::class, 'detachProgram']);

Route::resource('exercises', ExerciseController::class);

Route::resource('programs', ProgramController::class);
