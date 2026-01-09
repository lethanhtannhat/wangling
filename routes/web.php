<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetListController;
use App\Http\Controllers\AssetManagementController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // 1. Dashboard (Core)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 2. Feature: Asset Listing
    if (config('features.asset_list')) {
        Route::prefix('assets')->name('assets.')->group(function () {
            Route::get('/list', [AssetListController::class, 'index'])->name('list');
        });
    }
    // 3. Feature: Asset Management (Create)
    if (config('features.asset_create')) {
        Route::prefix('assets')->name('assets.')->group(function () {
            Route::get('/create', [AssetManagementController::class, 'create'])->name('create');
            Route::post('/', [AssetManagementController::class, 'store'])->name('store');
        });
    }

    // Check ID availability for both Create and Edit
    if (config('features.asset_create') || config('features.asset_edit')) {
        Route::get('assets/check-id', [AssetManagementController::class, 'checkId'])->name('assets.check-id');
    }

    // 4. Feature: Asset Management (Edit/Delete)
    Route::prefix('assets')->name('assets.')->group(function () {
        if (config('features.asset_edit')) {
            Route::get('/{asset}/edit', [AssetManagementController::class, 'edit'])->name('edit');
            Route::put('/{asset}', [AssetManagementController::class, 'update'])->name('update');
        }
        if (config('features.asset_delete')) {
            Route::delete('/{asset}', [AssetManagementController::class, 'destroy'])->name('destroy');
        }
    });

});

require __DIR__.'/auth.php';
