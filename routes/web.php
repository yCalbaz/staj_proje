<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ProductController;
use App\Models\Order;

Route::get('/', [HomeProductController::class, 'productHome']);

Route::get('/urun', [ProductController::class, 'index'])->name('urun');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); 
Route::post('/login', [AuthController::class, 'login'])->name('login.post'); 

Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');



Route::middleware(['auth'])->group(function () {
    Route::get('/adminPanel', [ManagerController::class, 'showAdminPanel'])->name('adminPanel'); 
    Route::get('/saticiPanel', [ManagerController::class, 'showSaticiPanel'])->name('saticiPanel');
    Route::get('/saticiPanel', [ManagerController::class, 'showSellerStores'])->name('saticiPanel'); 
    Route::get('/seller/orders/{storeId}', [ManagerController::class, 'showSellerOrders'])->name('seller.orders');
    Route::post('/seller/orders/{lineId}/status', [ManagerController::class, 'updateLineStatus'])->name('seller.updateLineStatus');
    Route::get('/musteriPanel', [ManagerController::class, 'showMusteriPanel'])->name('musteriPanel'); 
    Route::post('/seller/orders/store/update-status', [ManagerController::class, 'updateLineStatusForStore'])->name('seller.updateLineStatusForStore');
    Route::get('/urunPanel', [HomeProductController::class, 'index'])->name('product.index.form');
    Route::get('Urunlerim' , [OrderController::class, 'sellerProduct'])->name('seller.product');
    Route::get('/depoPanel', [StoreController::class, 'index'])->name('store.index.form');
    Route::get('/stokPanel', [StockController::class, 'index'])->name('stock.index.form');
    Route::get('/uyeler', [MemberController::class, 'index'])->name('members.index');
    Route::delete('/uyeler/{id}', [MemberController::class, 'delete'])->name('members.delete');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});

Route::post('/products', [HomeProductController::class, 'store'])->name('products.store'); 
Route::post('/store', [StoreController::class, 'store'])->name('store.store');
Route::post('/stock', [StockController::class, 'store'])->name('stock.store');

Route::get('/sepet', [BasketController::class, 'index'])->name('sepet.index');
Route::post('/cart/add/{product_sku}', [BasketController::class, 'add'])->name('cart.add');
Route::get('/cart', [BasketController::class, 'index'])->name('cart.index');
Route::delete('/cart/{id}', [BasketController::class, 'delete'])->name('cart.delete');
Route::post('/sepet/onay', [BasketController::class, 'approvl'])->name('sepet.approvl');
Route::get('/sepet/onay', [BasketController::class, 'approvl'])->name('   ');



Route::get('/musteri/uye-ol', [AuthController::class, 'showRegisterForm'])->name('musteri.uye_ol');
Route::post('/musteri/uye-ol', [AuthController::class, 'customerRegister'])->name('musteri.uye_ol.kayit');

Route::get('/urun/{sku}', [ProductController::class, 'showDetails'])->name('product.details');


Route::middleware(['auth'])->group(function () {        
    Route::get('/siparisler', [OrderDetailController::class, 'index'])->name('orders.index');
    Route::get('/order/{orderId}/detaylar', [OrderDetailController::class, 'showDetails'])->name('order.showDetails');
    Route::get('/orders/{orderId}/return/{store_id}', [OrderDetailController::class, 'showReturnForm'])->name('order.returnForm');
    Route::post('/siparis/iade', [OrderDetailController::class, 'processReturn'])->name('order.processReturn');
    Route::post('/seller/orders/approve-cancellation', [ManagerController::class, 'approveCancellation'])->name('seller.approveCancellation');});
    Route::get('/order-canseled-form', [OrderDetailController::class, 'showCanceledForm'])->name('order.canceledForm');
    Route::get('/admin/siparisler', [OrderDetailController::class, 'adminOrders'])->name('orders.indexAdmin');
    Route::get('/admin/siparis/{orderId}/detaylar', [OrderDetailController::class, 'showAdminDetails'])->name('order.showAdminDetails');

Route::put('/sepet/guncelle/{id}', [BasketController::class, 'update'])->name('cart.update');
Route::get('/search', [App\Http\Controllers\ProductController::class, 'search'])->name('search');

Route::get('/kategori/{category_slug}', [ProductController::class, 'productCategory'])->name('category.product');
Route::get('/get-products-by-category', [ProductController::class, 'getProductsByCategory'])->name('get.products.by.category');


Route::get('/products/brand/{brand}', [ProductController::class, 'brand'])->name('products.brand'); 
Route::get('/product/{sku}/sizes', [ProductController::class, 'getSizes'])->name('product.sizes');
