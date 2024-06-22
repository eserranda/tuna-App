<?php

use App\Http\Controllers\CuttingController;
use App\Http\Controllers\RawMaterialLotsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ReceivingController;
use App\Http\Controllers\RefinedMaterialLotsController;
use App\Models\Cutting;

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

Route::prefix('refined-material-lots')->controller(RefinedMaterialLotsController::class)->group(function () {
    Route::get('/{ilc_cutting}', 'index')->name('refined_material_lots.index');
    Route::post('/store', 'store')->name('refined_material_lots.store');
    Route::get('/getAll/{ilc_cutting}', 'getAll')->name('refined_material_lots.getAll');
    Route::get('/nextNumber/{ilc_cutting}', 'nextNumber')->name('refined_material_lots.nextNumber');
    Route::delete('/{id}', 'destroy')->name('refined_material_lots.destroy');


    // Route::get('/getAllReceiving', 'getAllReceiving')->name('cutting.getAllReceiving');
});

Route::prefix('cutting')->controller(CuttingController::class)->group(function () {
    Route::get('/', 'index')->name('cutting.index');
    Route::get('/getAllReceiving', 'getAllReceiving')->name('cutting.getAllReceiving');
    Route::post('/store', 'store')->name('cutting.store');
    Route::get('/getAll', 'getAll')->name('cutting.getAll');
    Route::delete('/{id}', 'destroy')->name('cutting.destroy');
});


Route::prefix('raw-material-lots')->controller(RawMaterialLotsController::class)->group(function () {
    Route::get('/', 'index')->name('raw_material_lots.index');
    Route::get('/findOne/{ilc}', 'findOne')->name('raw_material_lots.getAll');
    Route::post('/store', 'store')->name('raw_material_lots.store');
    Route::get('/grading/{ilc}', 'grading')->name('receiving.grading');
    Route::delete('/{id}', 'destroy')->name('raw_material_lots.destroy');


    // belum di pakai 
    Route::get('/get', 'get')->name('raw_material_lots.get');
    Route::get('/create', 'create')->name('raw_material_lots.create');
    Route::get('/{rawMaterialLots}', 'show')->name('raw_material_lots.show');
    Route::get('/{rawMaterialLots}/edit', 'edit')->name('raw_material_lots.edit');
    Route::put('/{rawMaterialLots}', 'update')->name('raw_material_lots.update');
});

Route::prefix('receiving')->controller(ReceivingController::class)->group(function () {
    Route::get('/', 'index')->name('receiving.index');
    Route::get('/getAll', 'getAll')->name('receiving.getAll');
    Route::delete('/{id}', 'destroy')->name('receiving.destroy');
    // Route::get('/grading/{ilc}', 'grading')->name('receiving.grading');


    // belum di pakai 
    Route::get('/create', 'create')->name('receiving.create');
    Route::post('/store', 'store')->name('receiving.store');
    Route::get('/{receiving}', 'show')->name('receiving.show');
    Route::get('/{receiving}/edit', 'edit')->name('receiving.edit');
    Route::put('/{receiving}', 'update')->name('receiving.update');
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
