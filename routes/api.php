<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function (){
    // Auth User
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user',[AuthController::class, 'user']);

    // Post
    Route::post('/post/add', [PostController::class, 'store']);
    Route::get('/post/all', [PostController::class, 'index']);
    Route::get('/post/show/{id}', [PostController::class, 'show']);
    Route::post('/post/update/{id}', [PostController::class, 'update']);

});
