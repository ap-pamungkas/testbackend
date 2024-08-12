<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DivisionController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::controller(AuthController::class)->group(function () {
      Route::post('/login', 'login');
      Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index');
        Route::put('/users/{id}', 'update');
    });


    Route::controller(DivisionController::class)->group(function () {
        Route::get('/divisions', 'index');
    });

  
    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/employees', 'index');
        Route::post('/employees','store');
        Route::put('/employees/{id}','update');
        Route::delete('/employees/{id}','destroy');
    });
});



