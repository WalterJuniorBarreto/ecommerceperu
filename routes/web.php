<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Surfsidemedia\Shoppingcart\Facades\Cart;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/tienda', [ShopController::class, 'index'])->name('shop.index');
Route::get('/tienda/{product_slug}', [ShopController::class, 'product_details'])->name('shop.product.details');
/*Route::get('/carrito/clear', function () {
    Cart::instance('cart')->destroy(); // 🔥 Esto limpia la sesión del carrito
    return redirect('/cart')->with('success', 'Carrito vaciado correctamente.');
});*/





Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrito/agregar', [CartController::class, 'add_to_cart'])->name('cart.add');
Route::put('/carrito/aumentar-cantidad/{rowId}',[CartController::class,'increase_item_quantity'])->name('cart.increase.qty');
Route::put('/carrito/disminuir-cantidad/{rowId}',[CartController::class,'reduce_item_quantity'])->name('cart.reduce.qty');
Route::delete('/carrito/remover/{rowId}',[CartController::class,'remove_item_from_cart'])->name('cart.remove');
Route::delete('/carrito/eliminar',[CartController::class,'empty_cart'])->name('cart.empty');

Route::post('/lista-deseos/agregar',[WishlistController::class,'add_to_wishlist'])->name('wishlist.add');
Route::get('/lista-deseos', [WishlistController::class, 'index'])->name('wishlist.index');
Route::delete('/lista-deseos/remover/item/{rowId}',[WishlistController::class,'remove_item'])->name('wishlist.item.remove');
Route::delete('/lista-deseos/eliminar',[WishlistController::class,'empty_wishlist'])->name('wishlist.items.clear');
Route::post('/lista-deseos/mover-del-carrito/{rowId}',[WishlistController::class,'move_to_cart'])->name('wishlist.move.to.cart');


Route::get('/checkout',[CartController::class,'checkout'])->name('cart.checkout');

Route::post('/realizar-orden',[CartController::class,'place_order'])->name('cart.place.order');
Route::get('/orden-confirmacion',[CartController::class,'order_confirmation'])->name('order.confirmation');

Route::get('/contactanos', [HomeController::class, 'contact'])->name('home.contact');
Route::get('/nosotros', [HomeController::class, 'nosotros'])->name('home.nosotros');
Route::post('/contact/store', [HomeController::class, 'contact_store'])->name('home.contact.store');

Route::get('/buscar', [HomeController::class, 'search'])->name('home.search');


Route::middleware(['auth'])->group(function(){
    Route::get('/cuenta-dashboard', [UserController::class, 'index'])->name('user.index');
    Route::get('/cuenta-ordenes',[UserController::class,'account_orders'])->name('user.account.orders');
    Route::get('/cuenta-ordenes/{order_id}/detalles',[UserController::class,'account_order_details'])->name('user.account.order.details');
});
Route::middleware(['auth', AuthAdmin::class])->group(function(){
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/brands', [AdminController::class, 'brands'])->name('admin.brands');
    Route::get('/admin/brand/add', [AdminController::class, 'add_brand'])->name('admin.brand.add');
    Route::post('/admin/brand/store', [AdminController::class, 'brand_store'])->name('admin.brand.store');
    Route::get('/admin/brand/edit/{id}', [AdminController::class, 'brand_edit'])->name('admin.brand.edit');
    Route::put('/admin/brand/update', [AdminController::class, 'brand_update'])->name('admin.brand.update');
    Route::delete('/admin/brand/{id}/delete', [AdminController::class, 'brand_delete'])->name('admin.brand.delete');

    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/category/add', [AdminController::class, 'category_add'])->name('admin.category.add');
    Route::post('/admin/category/store', [AdminController::class, 'category_store'])->name('admin.category.store');
    Route::get('/admin/category/{id}/edit', [AdminController::class, 'category_edit'])->name('admin.category.edit');
    Route::put('/admin/category/update', [AdminController::class, 'category_update'])->name('admin.category.update');
    Route::delete('/admin/category/{id}/delete', [AdminController::class, 'category_delete'])->name('admin.category.delete');

    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/product/add', [AdminController::class, 'product_add'])->name('admin.product.add');
    Route::post('/admin/product/store', [AdminController::class, 'product_store'])->name('admin.product.store');
    Route::get('/admin/product/{id}/edit', [AdminController::class, 'product_edit'])->name('admin.product.edit');
    Route::put('/admin/product/update', [AdminController::class, 'product_update'])->name('admin.product.update');
    Route::delete('/admin/product/{id}/delete', [AdminController::class, 'product_delete'])->name('admin.product.delete');

    Route::get('/admin/orders',[AdminController::class,'orders'])->name('admin.orders');
    Route::get('/admin/order/{order_id}/details',[AdminController::class,'order_details'])->name('admin.order.details');
    Route::put('/admin/order/update-status',[AdminController::class,'update_order_status'])->name('admin.order.status.update');

    Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');

});
