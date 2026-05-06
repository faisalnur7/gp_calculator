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

    Route::get('/reports/items',          [ReportController::class, 'items'])->name('reports.items');
    Route::get('/reports/items/pdf',       [ReportController::class, 'itemsPdf'])->name('reports.items.pdf');
    Route::get('/reports/shops',           [ReportController::class, 'shops'])->name('reports.shops');
    Route::get('/reports/shops/pdf',       [ReportController::class, 'shopsPdf'])->name('reports.shops.pdf');
    Route::get('/reports/inventory',       [ReportController::class, 'inventory'])->name('reports.inventory');
    Route::get('/reports/inventory/pdf',   [ReportController::class, 'inventoryPdf'])->name('reports.inventory.pdf');
});
