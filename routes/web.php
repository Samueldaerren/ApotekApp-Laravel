<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
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
Route::middleware(['IsGuest'])->group(function() {
Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');
Route::get('/', [UserController::class, 'showLogin'])->name('login');
});

// Route::middleware(['IsLogin'])->group(function() {
    Route::get('/landing', [LandingPageController::class, 'index'])->name('landing_page');
    Route::get('/logout' , [UserController::class, 'logout'])->name('logout');
    Route::middleware(['IsAdmin'])->group(function() {
    Route::get('/order', [OrderController::class, 'indexAdmin'])->name('pembelian.admin');
    Route::get('/order/export-excel', [OrderController::class, 'exportExcel'])->name('pembelian.admin.export'); 
    Route::get('/medicine/export-excel', [MedicineController::class, 'exportExcel'])->name('medicine.admin.export');
    Route::get('/user/export-excel', [UserController::class, 'exportExcel'])->name('user.admin.export');
    Route::prefix('/Medicine')->name('medicine.')->group(function(){
        Route::get('/Add-Medicine' , [MedicineController::class, 'create'])->name('create');
        Route::post('/create-Medicine' , [MedicineController::class, 'store'])->name('create.obat');
        Route::get('/medicines/showdata' , [MedicineController::class, 'index'])->name('show');
        Route::get('/medicines/edit/{id}' , [MedicineController::class, 'edit'])->name('edit');
        Route::patch('/medicines/update/{id}' , [MedicineController::class, 'update'])->name('edit.form');
        Route::delete('/medicines/delete/{id}' , [MedicineController::class, 'destroy'])->name('destroy');
        Route::patch('/edit/stock/{id}' , [MedicineController::class, 'updateStock']) ->name('update.stock');
    });
});

   

    Route::prefix('/User')->name('user.')->group(function(){
        Route::get('/users' , [UserController::class, 'index'])->name('index');   //route index mengarahkan ke method index di class UserController kegunaan dari get nya adalh untuk mengambil data dari database
        Route::get('/create' , [UserController::class, 'create'])->name('create');  //route create mengarahkan ke method create di class UserController
        Route::post('/create-user' , [UserController::class, 'store'])->name('store');
        //kegunaan post untuk menambahkan data ke database
        Route::get('/edit/{id}' , [UserController::class, 'edit'])->name('edit');
        Route::patch('/update/{id}' , [UserController::class, 'update'])->name('update');
        //kegunaan patch untuk mengupdate data secara speksifik
        Route::delete('/destroy/{id}' , [UserController::class, 'destroy'])->name('destroy');
        //kegunaan delete untuk menghapus data dari database
    });

    
    Route::middleware('IsKasir')->group(function() {
        Route::prefix('/pembelian')->name('pembelian.')->group(function() {
            Route::get('/order', [OrderController::class, 'index'])->name('index');
            Route::get('/formulir', [OrderController::class, 'create'])->name('formulir'); 
            Route::post('/create-order', [OrderController::class, 'store'])->name('store'); 
            Route::get('/print/{id}', [OrderController::class, 'show'])->name('print');   
            Route::get('/search', [OrderController::class, 'search'])->name('search');
            Route::get('/download-pdf/{id}', [OrderController::class, 'downloadPDF'])->name('download_pdf');
        });
    });

