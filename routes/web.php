<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetListController;


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
    
});

require __DIR__.'/auth.php';
