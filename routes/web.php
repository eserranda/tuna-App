<?php

use App\Models\Cutting;
use App\Models\Packing;
use App\Models\ReceivingChecking;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GradesController;
use App\Http\Controllers\CuttingController;
use App\Http\Controllers\PackingController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ReceivingController;
use App\Http\Controllers\ProductLogController;
use App\Http\Controllers\RetouchingController;
use App\Http\Controllers\CuttingCheckingController;
use App\Http\Controllers\RawMaterialLotsController;
use App\Http\Controllers\ReceivingCheckingController;
use App\Http\Controllers\RefinedMaterialLotsController;

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

Route::prefix('packing')->controller(PackingController::class)->group(function () {
    Route::get('/', 'index')->name('packing.index');
    Route::post('/store', 'store');
    Route::post('/update', 'update');
    Route::get('/getAllDatatable', 'getAllDatatable')->name('get-all-packing');
    Route::get('/customer-produk/{id_customer}/{id_produk}', 'customerProduk');
    Route::delete('/{id}', 'destroy')->name('packing.destroy');

    Route::get('/getAllDataProductLog', 'getAllDataProductLog')->name('get-all-product-log');
});

Route::prefix('cutting-checking')->controller(CuttingCheckingController::class)->group(function () {
    Route::get('/', 'index')->name('cutting-checking.index');
    Route::post('/update', 'update');
});

Route::prefix('receiving-checking')->controller(ReceivingCheckingController::class)->group(function () {
    Route::get('/', 'index')->name('receiving-checking.index');
    Route::post('/update', 'update');
});


Route::prefix('product-log')->controller(ProductLogController::class)->group(function () {
    Route::get('/{ilc}', 'index')->name('product_log.index');
    Route::post('/store', 'store');
    // Route::get('/', 'index')->name('grades.index');
    // Route::get('/getAll', 'getAll')->name('grades.getAll');
    Route::delete('/{id}', 'destroy')->name('grades.destroy');
});

Route::prefix('print')->controller(PrinterController::class)->group(function () {
    Route::get('/product-log-print/{id_product}/{ilc}', 'productLogPrint');
});

Route::prefix('grades')->controller(GradesController::class)->group(function () {
    Route::get('/', 'index')->name('grades.index');
    Route::post('/store', 'store')->name('grades.store');
    Route::get('/getAll', 'getAll')->name('grades.getAll');
    Route::get('/getAllData', 'getAllData')->name('grades.getAllData');
    Route::delete('/{id}', 'destroy')->name('grades.destroy');
});

Route::prefix('produk')->controller(ProductsController::class)->group(function () {
    Route::get('/', 'index')->name('produk.index');
    Route::post('/store', 'store')->name('produk.store');
    Route::delete('/{id}', 'destroy')->name('produk.destroy');

    Route::delete('/{id}', 'destroy')->name('produk.destroy');
    Route::get('/get/{customer_group}', 'get')->name('produk.get');

    Route::get('/getAllData', 'getAllData')->name('produk.getAllData');
    Route::get('/getAllDataProductLog', 'getAllDataProductLog')->name('produk.get-all-product-log');
    Route::get('/productWithCustomerGroup/{customer_group}', 'productWithCustomerGroup');
});

Route::prefix('customer')->controller(CustomersController::class)->group(function () {
    Route::get('/', 'index')->name('customer.index');
    Route::get('/getAllData', 'getAllData')->name('customer.getAllData');
    Route::get('/add', 'add')->name('customer.add');
    Route::post('/store', 'store')->name('customer.store');
    Route::delete('/{id}', 'destroy')->name('customer.destroy');
    Route::get('/get', 'get')->name('customer.get');
});


Route::prefix('retouching')->controller(RetouchingController::class)->group(function () {
    Route::get('/', 'index')->name('retouching.index');
    Route::get('/getAll', 'getAll')->name('retouching.getAll');
    Route::post('/', 'store')->name('retouching.store');
    Route::delete('/{id}', 'destroy')->name('retouching.destroy');
    Route::get('/getAllCutting', 'getAllCutting')->name('retouching.getAllCutting');

    Route::get('/getNoIkan/{ilc_cutting}', 'getNoIkan')->name('retouching.getNoIkan');

    Route::get('/calculateLoin/{ilc_cutting}/{no_ikan}', 'calculateLoin')->name('retouching.calculateLoin');
});

Route::prefix('refined-material-lots')->controller(RefinedMaterialLotsController::class)->group(function () {
    Route::get('/{ilc_cutting}', 'index')->name('refined_material_lots.index');
    Route::post('/store', 'store')->name('refined_material_lots.store');
    Route::get('/getAll/{ilc_cutting}', 'getAll')->name('refined_material_lots.getAll');
    Route::get('/nextNumber/{ilc_cutting}/{no_ikan}', 'nextNumber')->name('refined_material_lots.nextNumber');
    Route::delete('/{id}', 'destroy')->name('refined_material_lots.destroy');

    Route::get('/calculateTotalWeight/{ilc}', 'calculateTotalWeight')->name('refined_material_lots.calculateTotalWeight');

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

    Route::get('/calculateTotalWeight/{ilc}', 'calculateTotalWeight')->name('raw_material_lots.calculateTotalWeight');


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
    Route::delete('/{id}/{ilc}', 'destroy')->name('receiving.destroy');
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
