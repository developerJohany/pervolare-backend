<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
Route::group(['prefix' => 'auth'], function($router) {
        Route::post('/login',    [AuthController::class, 'login']);
        Route::post('/logout',   [AuthController::class, 'logout']);
        Route::post('/refresh',  [AuthController::class, 'refresh']);
        Route::post('/profile',  [AuthController::class, 'profile']);
    });
Route::apiResource('categories',   'App\Http\Controllers\CategoryController');




