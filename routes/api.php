<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoldPriceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**
 * Gold Price API Routes
 */
Route::prefix('gold')->group(function () {
    // Get all prices (all weights)
    Route::get('/prices', [GoldPriceController::class, 'getAllPrices']);
    
    // Get prices for specific brand
    Route::get('/prices/{brand}', [GoldPriceController::class, 'getPricesByBrand']);
    
    // Compare prices across brands
    Route::get('/compare', [GoldPriceController::class, 'comparePrice']);
    
    // Calculate total price
    Route::get('/calculate', [GoldPriceController::class, 'calculatePrice']);
    
    // Get statistics
    Route::get('/stats', [GoldPriceController::class, 'getStats']);
    
    // Get today's 1g prices (Asia/Jakarta)
    Route::get('/today', [GoldPriceController::class, 'today']);
});
