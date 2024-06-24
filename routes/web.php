<?php

use App\Http\Controllers\CustomersController;
use App\Http\Controllers\CuttingController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RawMaterialLotsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ReceivingController;
use App\Http\Controllers\RefinedMaterialLotsController;
use App\Http\Controllers\RetouchingController;
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

Route::prefix('produk')->controller(ProductsController::class)->group(function () {
    Route::get('/', 'index')->name('produk.index');
    Route::get('/add', 'add')->name('produk.add');
    Route::get('/getAllData', 'getAllData')->name('produk.getAllData');

    // Route::get('/add', 'add')->name('customer.add');
    // Route::post('/store', 'store')->name('customer.store');
    // Route::delete('/{id}', 'destroy')->name('retouching.destroy');
});

Route::prefix('customer')->controller(CustomersController::class)->group(function () {
    Route::get('/', 'index')->name('customer.index');
    Route::get('/getAllData', 'getAllData')->name('customer.getAllData');
    Route::get('/add', 'add')->name('customer.add');
    Route::post('/store', 'store')->name('customer.store');
    Route::delete('/{id}', 'destroy')->name('retouching.destroy');
});


Route::prefix('retouching')->controller(RetouchingController::class)->group(function () {
    Route::get('/', 'index')->name('retouching.index');
    Route::get('/getAll', 'getAll')->name('retouching.getAll');
    Route::post('/', 'store')->name('retouching.store');
    Route::delete('/{id}', 'destroy')->name('retouching.destroy');
    Route::get('/getAllCutting', 'getAllCutting')->name('retouching.getAllCutting');

    // Route::post('/store', 'store')->name('retouching.store');
    // Route::get('/getAll/{ilc_cutting}', 'getAll')->name('retouching.getAll');
    // Route::get('/nextNumber/{ilc_cutting}/{no_ikan}', 'nextNumber')->name('retouching.nextNumber');
    // Route::delete('/{id}', 'destroy')->name('retouching.destroy');
    // Route::get('/getAllReceiving', 'getAllReceiving')->name('retouching.getAllReceiving');
});

Route::prefix('refined-material-lots')->controller(RefinedMaterialLotsController::class)->group(function () {
    Route::get('/{ilc_cutting}', 'index')->name('refined_material_lots.index');
    Route::post('/store', 'store')->name('refined_material_lots.store');
    Route::get('/getAll/{ilc_cutting}', 'getAll')->name('refined_material_lots.getAll');
    Route::get('/nextNumber/{ilc_cutting}/{no_ikan}', 'nextNumber')->name('refined_material_lots.nextNumber');
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
    Route::get('/getNoIkan/{ilc}', 'getNoIkan')->name('raw_material_lots.get_no_ikan');
    Route::get('/nextNumber/{ilc}', 'nextNumber')->name('raw_material_lots.nextNumber');


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
    Route::get('/getAllData', 'getAllData')->name('supplier.getAllData');
    Route::delete('/{id}', 'destroy')->name('supplier.destroy');

    // belum di pakai
    Route::get('/get', 'get')->name('supplier.get');
    Route::get('/create', 'create')->name('supplier.create');
    Route::post('/store', 'store')->name('supplier.store');
    Route::get('/{supplier}', 'show')->name('supplier.show');
    Route::get('/{supplier}/edit', 'edit')->name('supplier.edit');
    Route::put('/{supplier}', 'update')->name('supplier.update');
});
