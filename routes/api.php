<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MessageController;

// Routes protégées
Route::middleware('auth:sanctum')->group(function () {
    //profil
    Route::get('/profile', [AuthController::class, 'me']);

    //update user profile
    Route::put(uri:'/profile', action: [AuthController::class, 'updateProfile']);

    // Gestion des annonces
    Route::apiResource('cars', CarController::class)->except(['index', 'show']);
    
    // Favoris
    Route::post('/cars/{car}/favorite', [FavoriteController::class, 'toggle']);
    Route::get('/favorites', [FavoriteController::class, 'index']);

    // Messages
    Route::post('/cars/{car}/message', [MessageController::class, 'send']);
});


// Routes publiques
    Route::apiResource('cars', CarController::class)->only(['index', 'show']);

    
// Authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);