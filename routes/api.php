<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::post('/login', [AuthController::class, 'login']); // Verwendung der Array-Syntax für Controller

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']); // Duplizierte Route entfernt

Route::get('/users', [UserController::class, 'index']); // Verwendung der Array-Syntax für Controller
Route::get('/knowledge_categories', [ArticleController::class, 'fetch_categories']);
Route::post('/knowledge_categories', [ArticleController::class, 'add_categories']);
Route::post('/knowledge_topic', [ArticleController::class, 'add_topic']);
Route::get('/knowledge_topic', [ArticleController::class, 'fetch_topics']);
