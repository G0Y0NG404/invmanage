<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return view('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:5,15');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [LoginController::class, 'profile'])->name('profile');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/receiving', [InventoryController::class, 'receiving'])->name('receiving');
    Route::post('/receiving', [InventoryController::class, 'store'])->name('receiving.store');

    Route::get('/tracking', [InventoryController::class, 'tracking'])->name('tracking');
    Route::post('/tracking/{item}/update', [InventoryController::class, 'updateStatus'])->name('tracking.update');
    Route::delete('/tracking/{item}', [InventoryController::class, 'destroy'])->name('tracking.destroy');
    Route::post('/tracking/{item}/restore', [InventoryController::class, 'restore'])->name('tracking.restore')->withTrashed();

    Route::get('/maintenance', [InventoryController::class, 'maintenance'])->name('maintenance');

    Route::get('/issuance', [InventoryController::class, 'issuance'])->name('issuance');
    Route::post('/issuance/checkout', [InventoryController::class, 'checkout'])->name('issuance.checkout');

    Route::get('/audit', [InventoryController::class, 'audit'])->name('audit');
    Route::get('/audit/export/csv', [InventoryController::class, 'exportCsv'])->name('audit.export.csv');

    Route::get('/tracking/{item}/edit', [InventoryController::class, 'editItem'])->name('tracking.edit');
    Route::put('/tracking/{item}', [InventoryController::class, 'updateItem'])->name('tracking.updateItem');


});
