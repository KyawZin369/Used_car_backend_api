<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\BitController;
use App\Http\Middleware\AdminMiddleware;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);


Route::middleware('auth:sanctum')->group(function () {
    // User-specific routes
    Route::get('/user', [UserController::class, 'index']);

    Route::prefix('/user/car')->group(function () {
        Route::post('/', [CarController::class, 'store']);
        Route::get('/', [CarController::class, 'index']);
        Route::get('/{id}', [CarController::class, 'show']);
    });

    Route::prefix('/user/bit')->group(function () {
        Route::get('/', [BitController::class, 'index']);
        Route::get('/{id}', [BitController::class, 'show']);
        Route::put('/{id}', [BitController::class, 'update']);
    });

    Route::get('/user/{id}', [UserController::class,'show']);

    // Admin routes (protected by 'admin' middleware)
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('/admin', [AdminController::class, 'index']);

        Route::prefix('/admin/car')->group(function () {
            Route::post('/', [CarController::class, 'store']);
            Route::get('/', [CarController::class, 'index']);
            Route::get('/{id}', [CarController::class, 'show']);
            Route::put('/{id}', [CarController::class, 'update']);
            Route::delete('/{id}', [CarController::class, 'destroy']);
        });

        Route::prefix('/bit')->group(function () {
            Route::post('/', [BitController::class, 'store']);
            Route::get('/', [BitController::class, 'index']);
            Route::get('/{id}', [BitController::class, 'show']);
            Route::put('/{id}', [BitController::class, 'update']);
            Route::delete('/{id}', [BitController::class, 'destroy']);
        });
    });
});
