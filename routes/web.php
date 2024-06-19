<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ReceivingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard.index');
});


Route::prefix('receiving')->controller(ReceivingController::class)->group(function () {
    Route::get('/', 'index')->name('receiving.index');
    Route::get('/create', 'create')->name('receiving.create');
    Route::post('/store', 'store')->name('receiving.store');
    Route::get('/{receiving}', 'show')->name('receiving.show');
    Route::get('/{receiving}/edit', 'edit')->name('receiving.edit');
    Route::put('/{receiving}', 'update')->name('receiving.update');
    Route::delete('/{receiving}', 'destroy')->name('receiving.destroy');
});


Route::prefix('supplier')->controller(SupplierController::class)->group(function () {
    Route::get('/', 'index')->name('supplier.index');
    Route::get('/add', 'add')->name('supplier.add');

    Route::get('/get', 'get')->name('supplier.get');

    Route::get('/create', 'create')->name('supplier.create');
    Route::post('/store', 'store')->name('supplier.store');
    Route::get('/{supplier}', 'show')->name('supplier.show');
    Route::get('/{supplier}/edit', 'edit')->name('supplier.edit');
    Route::put('/{supplier}', 'update')->name('supplier.update');
    Route::delete('/{supplier}', 'destroy')->name('supplier.destroy');
});
