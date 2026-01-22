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

    // 5. Feature: User/Employee Management
    if (config('features.user_create') || config('features.user_list')) {
        Route::prefix('users')->name('users.')->group(function () {
            if (config('features.user_list')) {
                Route::get('/list', [\App\Http\Controllers\EmployeeController::class, 'index'])->name('list');
            }
            if (config('features.user_create')) {
                Route::get('/create', [\App\Http\Controllers\EmployeeController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\EmployeeController::class, 'store'])->name('store');
                Route::get('/check-unique', [\App\Http\Controllers\EmployeeController::class, 'checkUnique'])->name('check-unique');
            }
            if (config('features.user_edit')) {
                Route::get('/{employee}/edit', [\App\Http\Controllers\EmployeeController::class, 'edit'])->name('edit');
                Route::put('/{employee}', [\App\Http\Controllers\EmployeeController::class, 'update'])->name('update');
            }
            if (config('features.user_delete')) {
                Route::delete('/{employee}', [\App\Http\Controllers\EmployeeController::class, 'destroy'])->name('destroy');
            }
        });
    }

    // Check uniqueness for fields (Asset ID, Serial Number)
    if (config('features.asset_create') || config('features.asset_edit')) {
        Route::get('assets/check-unique', [AssetManagementController::class, 'checkUnique'])->name('assets.check-unique');
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
