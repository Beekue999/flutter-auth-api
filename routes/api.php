<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FirebaseController;

Route::prefix('v1')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:auth');
    Route::post('/login',    [AuthController::class, 'login'])->middleware('throttle:auth');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->middleware('throttle:auth');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->middleware('throttle:auth');

    // Email verification (API endpoints)
    Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Http\Request $request, $id, $hash) {
        // This endpoint will be hit by verify link. It requires signed URL verification.
        $user = \App\Models\User::findOrFail($id);
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return response()->json(['message' => 'Invalid verification link.'], 403);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.']);
        }

        $user->markEmailAsVerified();
        return response()->json(['message' => 'Email verified successfully.']);
    })->name('verification.verify');

    Route::post('/email/resend', function (\Illuminate\Http\Request $request) {
        $request->validate(['email' => 'required|email']);
        $user = \App\Models\User::where('email', $request->email)->first();
        if (! $user) {
            return response()->json(['message' => 'User not found.'], 404);
        }
        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.']);
        }
        $user->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification email resent.']);
    })->middleware('throttle:auth');

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

        // Firebase
        Route::get('/firebase/database',                [FirebaseController::class, 'showDatabase']);
        Route::get('/firebase/collection/{collection}', [FirebaseController::class, 'showCollection']);
    });
});
