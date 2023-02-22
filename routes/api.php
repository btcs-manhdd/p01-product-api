<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\SubProductController;

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


Route::controller(ProductController::class)->group(
    function () {
        Route::get('products', 'getAllProducts');
        Route::get('user/products', 'getAllUserProducts');
        Route::get('products/{id}', 'getProductById');
        Route::get('user/products/{id}', 'getProductByIdForUser');
        Route::post('products', 'createProduct');
        Route::post('products/{id}', 'updateProduct');
        Route::delete('products/{id}', 'deleteProduct');
    }
);

Route::prefix('sub-products')->group(function () {
    Route::get('/', [SubProductController::class, 'getAllSubProducts']);
    Route::get('/{id}', [SubProductController::class, 'getSubProductById']);
    Route::post('/', [SubProductController::class, 'createSubProduct']);
    Route::post('/{id}', [SubProductController::class, 'updateSubProduct']);
    Route::delete('/{id}', [SubProductController::class, 'deleteSubProduct']);
});


Route::prefix('sizes')->group(function () {
    Route::get('/', [SizeController::class, 'getAllSizes']);
    Route::get('/{id}', [SizeController::class, 'getSizeById']);
    Route::post('/', [SizeController::class, 'createSize']);
    Route::post('/{id}', [SizeController::class, 'updateSize']);
    Route::delete('/{id}', [SizeController::class, 'deleteSize']);
});

Route::prefix('colors')->group(function () {
    Route::get('/', [ColorController::class, 'getAllColors']);
    Route::get('/{id}', [ColorController::class, 'getColorById']);
    Route::post('/', [ColorController::class, 'createColor']);
    Route::post('/{id}', [ColorController::class, 'updateColor']);
    Route::delete('/{id}', [ColorController::class, 'deleteColor']);
});

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'getAllCategories']);
    Route::get('/{id}', [CategoryController::class, 'getCategoryById']);
    Route::post('/', [CategoryController::class, 'createCategory']);
    Route::post('/{id}', [CategoryController::class, 'updateCategory']);
    Route::delete('/{id}', [CategoryController::class, 'deleteCategory']);
});

Route::prefix('statistics')->group(function () {
    Route::get('/category', [StatisticController::class, 'getCategoryStatistics']);
    Route::get('/new-products', [StatisticController::class, 'getNewProductsStatistics']);
    Route::get('/most-sale-off', [StatisticController::class, 'getSaleOffProductsStatistics']);
    Route::get('/rank-cost', [StatisticController::class, 'getRankCostProduct']);
});
