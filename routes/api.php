<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatistiController;
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

Route::controller(SizeController::class)->group(
    function () {
        Route::get('sizes', 'getAllSizes');
        Route::get('sizes/{id}', 'getSizeById');
        Route::post('sizes', 'createSize');
        Route::post('sizes/{id}', 'updateSize');
        Route::delete('sizes/{id}', 'deleteSize');
    }
);

Route::controller(ColorController::class)->group(
    function () {
        Route::get('colors', 'getAllColors');
        Route::get('colors/{id}', 'getColorById');
        Route::post('colors', 'createColor');
        Route::post('colors/{id}', 'updateColor');
        Route::delete('colors/{id}', 'deleteColor');
    }
);

Route::controller(CategoryController::class)->group(
    function () {
        Route::get('categories', 'getAllCategories');
        Route::get('categories/{id}', 'getCategoryById');
        Route::post('categories', 'createCategory');
        Route::post('categories/{id}', 'updateCategory');
        Route::delete('categories/{id}', 'deleteCategory');
    }
);

Route::controller(StatistiController::class)->group(
    function () {
        Route::get('statistics/category', 'getCategoryStatistics');
        Route::get('statistics/new-products', 'getNewProductsStatistics');
        Route::get('statistics/most-sale-off', 'getSaleOffProductsStatistics');
        Route::get('statistics/rank-cost', 'getRankCostProduct');
    }
);