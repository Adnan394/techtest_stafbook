<?php

use App\Http\Controllers\CategoryProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImageProductController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;


Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('product', [ProductController::class, 'index'])->name('product.index');
    Route::post('product', [ProductController::class, 'store'])->name('product.store');
    Route::put('edit_product', [ProductController::class, 'update'])->name('edit_product');
    Route::get('delete_product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    
    //category
    Route::post('create_category', [CategoryProductController::class, 'create_category'])->name('create_category');
    Route::get('delete_category/{id}', [CategoryProductController::class, 'delete_category'])->name('delete_category');
    Route::put('edit_category', [CategoryProductController::class, 'edit'])->name('edit_category');

    // image 
    Route::post('create_image', [ImageProductController::class, 'create_image'])->name('create_image');
    Route::get('delete_image/{id}', [ImageProductController::class, 'delete_image'])->name('delete_image');
    Route::put('edit_image', [ImageProductController::class, 'edit_image'])->name('edit_image');
});