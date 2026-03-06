<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetListController;
use App\Http\Controllers\AssetManagementController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StockController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    
    // 1. Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 2. Feature: Asset
    Route::prefix('assets')->name('assets.')->group(function () {
        Route::get('/list', [AssetListController::class, 'index'])
            ->middleware('feature:asset_list')->name('list');
            
        Route::get('/create', [AssetManagementController::class, 'create'])
            ->middleware('feature:asset_create')->name('create');
            
        Route::post('/create', [AssetManagementController::class, 'store'])
            ->middleware('feature:asset_create')->name('store');
            
        Route::get('/check-unique', [AssetManagementController::class, 'checkUnique'])
            ->name('check-unique');

        Route::get('/{asset}/edit', [AssetManagementController::class, 'edit'])
            ->middleware('feature:asset_edit')->name('edit');
            
        Route::put('/{asset}', [AssetManagementController::class, 'update'])
            ->middleware('feature:asset_edit')->name('update');
            
        Route::delete('/{asset}', [AssetManagementController::class, 'destroy'])
            ->middleware('feature:asset_delete')->name('destroy');
    });

    // 3. Feature: User/Employee
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/list', [EmployeeController::class, 'index'])
            ->middleware('feature:user_list')->name('list');
            
        Route::get('/create', [EmployeeController::class, 'create'])
            ->middleware('feature:user_create')->name('create');
            
        Route::post('/create', [EmployeeController::class, 'store'])
            ->middleware('feature:user_create')->name('store');
            
        Route::get('/check-unique', [EmployeeController::class, 'checkUnique'])
            ->name('check-unique');

        Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])
            ->middleware('feature:user_edit')->name('edit');
            
        Route::put('/{employee}', [EmployeeController::class, 'update'])
            ->middleware('feature:user_edit')->name('update');
            
        Route::delete('/{employee}', [EmployeeController::class, 'destroy'])
            ->middleware('feature:user_delete')->name('destroy');
    });

    // 4. Feature: Stock
    Route::prefix('stocks')->name('stocks.')->group(function () {
        Route::get('/list', [StockController::class, 'index'])
            ->middleware('feature:stock_list')->name('list');
            
        Route::get('/create', [StockController::class, 'create'])
            ->middleware('feature:stock_create')->name('create');
            
        Route::post('/create', [StockController::class, 'store'])
            ->middleware('feature:stock_create')->name('store');
            
        Route::get('/check-unique', [StockController::class, 'checkUnique'])
            ->name('check-unique');

        Route::get('/{stock}/edit', [StockController::class, 'edit'])
            ->middleware('feature:stock_edit')->name('edit');
            
        Route::put('/{stock}', [StockController::class, 'update'])
            ->middleware('feature:stock_edit')->name('update');
            
        Route::delete('/{stock}', [StockController::class, 'destroy'])
            ->middleware('feature:stock_delete')->name('destroy');
    });

});

require __DIR__.'/auth.php';
