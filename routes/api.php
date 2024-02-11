<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\SalesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('admin')->group(function () {
        Route::prefix('packages')->controller(PackageController::class)->name('package.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::patch('/{idPackage}', 'update')->name('update');
            Route::delete('/{idPackage}', 'destroy')->name('delete');
        });

        Route::prefix('sales')->controller(SalesController::class)->name('sales.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::patch('/{idSales}', 'update')->name('update');
            Route::delete('/{idSales}', 'destroy')->name('delete');
        });
    });

    Route::middleware('sales')->group(function () {
        Route::prefix('customers')->controller(CustomerController::class)->name('customer.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::post('/{idCustomer}', 'update')->name('update');
            Route::delete('/{idCustomer}', 'destroy')->name('delete');
        });
    });


    Route::post('logout', [AuthController::class, 'logout']);
});
