<?php

use App\Http\Controllers\NoteController;
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

Route::apiResource('note', NoteController::class);

Route::controller(\App\Http\Controllers\AuthController::class)->prefix('auth')->group(function (){
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::get('/logout', 'logout');
});

Route::controller(\App\Http\Controllers\CategoryController::class)->prefix('category')->group(function () {
    Route::post('/create', 'store');
    Route::get("/", 'index');
});

Route::controller(\App\Http\Controllers\QuestionController::class)->prefix('question')->group(function () {
    Route::post('/create', 'store');
    Route::get('/category/{id}', 'show');
    Route::post('/check', 'checkAnswer' );
});
