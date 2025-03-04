<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\StockController;
use App\Models\Product;



Route::get('/', function () {
    $products = Product::orderBy('id', 'desc')->take(10)->get(); 
    return view('anasayfa', compact('products'));
});

Route::get('/urunPanel', [ProductController::class, 'create'])->middleware('auth')->name('product.create.form');
Route::get('/depoPanel', [StoreController::class, 'create'])->middleware('auth')->name('store.create.form');
Route::get('/stokPanel', [StockController::class, 'create'])->middleware('auth')->name('stock.create.form');
Route::get('/adminPanel', function () { return view('admin_panel'); })->middleware('auth')->name('admin.panel');
Route::get('/sepet', [CartController::class, 'index'])->name('sepet.index');
Route::get('/urun', function () {  $products = Product::all(); 
    return view('urun', compact('products'));});

Route::get('/login', [AdminPanelController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminPanelController::class, 'login'])->name('admin.login');
Route::post('/logout', [AdminPanelController::class, 'logout'])->name('admin.logout'); 
Route::get('/register', [AdminPanelController::class, 'showRegistrationForm'])->name('uye_ol');
Route::post('/register', [AdminPanelController::class, 'register'])->name('admin.uye_ol');

Route::post('/products', [ProductController::class, 'store'])->name('products.store'); 
Route::post('/store', [StoreController::class, 'store'])->name('store.store');
Route::post('/stock', [StockController::class, 'store'])->name('stock.store');

Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/{id}', [CartController::class, 'delete'])->name('cart.delete');
Route::post('/sepet/onay', [CartController::class, 'approvl'])->name('sepet.approvl');
Route::get('/sepet/onay', [CartController::class, 'approvl'])->name('sepet.approvl');