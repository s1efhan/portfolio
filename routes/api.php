<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});