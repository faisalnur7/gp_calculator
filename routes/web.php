<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JewelleryCategoryController;
use App\Http\Controllers\JewelleryItemController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', fn() => view('welcome'));

    Route::resource('shops', ShopController::class);
    Route::resource('jewellery-categories', JewelleryCategoryController::class);
    Route::resource('jewellery-items', JewelleryItemController::class);

    Route::get('/reports/items',     [ReportController::class, 'items'])->name('reports.items');
    Route::get('/reports/shops',     [ReportController::class, 'shops'])->name('reports.shops');
    Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
});
