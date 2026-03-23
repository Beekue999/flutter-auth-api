<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout',         [AuthController::class, 'logout']);
    Route::get('/me',              [AuthController::class, 'user']);

    // Profile
    Route::put('/profile',         [ProfileController::class, 'update']);
    Route::put('/password',        [ProfileController::class, 'changePassword']);

    // Posts
    Route::get('/posts',           [PostController::class, 'index']);
    Route::post('/posts',          [PostController::class, 'store']);
    Route::get('/posts/{post}',    [PostController::class, 'show']);
    Route::put('/posts/{post}',    [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);

    // Admin
    Route::get('/admin/users',             [AdminController::class, 'users']);
    Route::delete('/admin/users/{id}',     [AdminController::class, 'deleteUser']);
    Route::put('/admin/users/{id}/toggle', [AdminController::class, 'toggleAdmin']);
});