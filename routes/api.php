<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;

Route::middleware('guest')->group(function () {
    // Authentification
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Public routes for cars (view all cars)
Route::apiResource('cars', CarController::class)->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Authenticated user can create, update, and delete their own cars
    Route::apiResource('cars', CarController::class)->except(['index', 'show']);

    // Routes for orders (authenticated users)
    Route::apiResource('orders', OrderController::class)->except(['create', 'edit']);

    // Admin routes
    Route::middleware('auth:sanctum', 'role:admin')->group(function () {
        // User Management
        Route::get('/admin/users', [AdminController::class, 'indexUsers']);
        Route::post('/admin/users', [AdminController::class, 'storeUser']);
        Route::put('/admin/users/{user}', [AdminController::class, 'updateUser']);
        Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser']);

        // Car Management
        Route::get('/admin/cars', [AdminController::class, 'indexCars']);
        Route::post('/admin/cars', [AdminController::class, 'storeCar']);
        Route::put('/admin/cars/{car}', [AdminController::class, 'updateCar']);
        Route::delete('/admin/cars/{car}', [AdminController::class, 'destroyCar']);

        // Order Management
        Route::get('/admin/orders', [AdminController::class, 'indexOrders']);
        Route::get('/admin/orders/{order}', [AdminController::class, 'showOrder']);
        Route::put('/admin/orders/{order}', [AdminController::class, 'updateOrder']);
        Route::delete('/admin/orders/{order}', [AdminController::class, 'destroyOrder']);
    });
});