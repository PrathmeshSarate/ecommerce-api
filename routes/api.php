<?php

use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\VariantController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// API Resource Route for Products
// Route::apiResource('products', ProductController::class);

// Search Route (separate for clarity)
// Route::get('products/search', [ProductController::class, 'search']);


//----------------NEW ROUTES---------

// Search
Route::get('/products/search/{data}', [ProductController::class, 'search'])->where('data', '[A-Za-z]+');;

// Products
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::put('/products/{product}', [ProductController::class, 'update']);
Route::delete('/products/{product}', [ProductController::class, 'destroy']);

// Variants
Route::get('/products/{product}/variants', [VariantController::class, 'index']);
Route::post('/products/{product}/variants', [VariantController::class, 'store']);
Route::get('/products/{product}/variants/{variant}', [VariantController::class, 'show']);
Route::put('/products/{product}/variants/{variant}', [VariantController::class, 'update']);
Route::delete('/products/{product}/variants/{variant}', [VariantController::class, 'destroy']);


