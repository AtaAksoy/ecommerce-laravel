<?php

use App\Events\BackEnd\MakeAnnuncement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
Route::get('/sepet', '\App\Http\Controllers\CartController@index')->name('cart');
Route::get('/sepet/sil/{code}', '\App\Http\Controllers\CartController@removeFromCart')->name('cart.removefrom');
Route::get('/odeme', '\App\Http\Controllers\CheckoutController@index')->name('checkout');
Route::post('/odeme/sonuc', '\App\Http\Controllers\CheckoutController@checkOutCheck');
Route::get('/odeme/{code}', '\App\Http\Controllers\CheckoutController@viewPurchasePage')->name('ordersuccess');
Route::post('/odeme', '\App\Http\Controllers\CheckoutController@checkOut');
Route::get('/arama', '\App\Http\Controllers\SearchController@index')->name('search');
Route::get('/isteklistesi', '\App\Http\Controllers\WishlistController@index')->name('wishlist');
Route::get('/isteklistesi/sil/{code}', '\App\Http\Controllers\WishlistController@removeFromList')->name('wishlist.removefromlist');
Route::get('/isteklistesi/ekle/{code}', '\App\Http\Controllers\WishlistController@addToCart')->name('wishlist.addtocart');
Route::group(['prefix' => 'hesap'], function () {
    Route::get('/', '\App\Http\Controllers\AccountController@dashboard')->name('account.dashboard');
    Route::get('/sifreyenile', '\App\Http\Controllers\AccountController@changePassword')->name('account.changepassword');

    Route::post('/', '\App\Http\Controllers\AccountController@indexPost');
});
Route::group(['prefix' => 'admin'], function() {
    # ADMIN GET ROUTES
    Route::get('/', '\App\Http\Controllers\Admin\AdminController@index')->name('admin.dashboard');
    Route::get('/giris', '\App\Http\Controllers\Admin\AdminLoginController@index')->name('admin.login');
    Route::get('cikis', '\App\Http\Controllers\Admin\AdminController@logout')->name('admin.logout');
    Route::get('/blog/olustur', '\App\Http\Controllers\Admin\AdminController@blogCreatePage')->name('admin.blog.createPage');
    Route::get('/blog', '\App\Http\Controllers\Admin\AdminController@blogList')->name('admin.blog.list');
    Route::get('/blog/duzenle/{slug}', '\App\Http\Controllers\Admin\AdminController@blogEditPage')->name('admin.blog.edit');
    Route::post('/blog/duzenle/{slug}', '\App\Http\Controllers\Admin\AdminController@blogEdit');
    Route::get('/kategoriler', '\App\Http\Controllers\Admin\CategoryController@index')->name('admin.category');
    Route::get('/kategori/sil/{slug}', '\App\Http\Controllers\Admin\CategoryController@deleteCategory')->name('admin.category.delete');
    Route::get('/kategoriler/{slug}', '\App\Http\Controllers\Admin\CategoryController@editCategoryPage')->name('admin.category.edit');
    Route::get('/urunler', '\App\Http\Controllers\Admin\ProductController@listProduct')->name('admin.products.list');
    Route::get('/urunler/ekle', '\App\Http\Controllers\Admin\ProductController@addProductPage')->name('admin.products.add');
    Route::get('/urun/duzenle/{code}', '\App\Http\Controllers\Admin\ProductController@editProductPage')->name('admin.products.edit');
    Route::get('/ayarlar/anasayfa', '\App\Http\Controllers\Admin\AdminController@settingHomePage')->name('admin.settings.homepage');
    Route::get('/duyuru', '\App\Http\Controllers\Admin\AdminController@announcement')->name('admin.announcement');
    Route::get('/indirim/yeni', '\App\Http\Controllers\Admin\AdminController@newDiscount')->name('admin.newDiscount');
    Route::get('/indirim', '\App\Http\Controllers\Admin\AdminController@listDiscount')->name('admin.listDiscount');
    Route::get('/indirim/duzenle/{id}', '\App\Http\Controllers\Admin\AdminController@editDiscount')->name('admin.editDiscount');
    Route::get('/indirim/sil/{id}', '\App\Http\Controllers\Admin\AdminController@deleteDiscount')->name('admin.deleteDiscount');
    Route::get('/siparisler', '\App\Http\Controllers\Admin\OrderController@showOrders')->name('admin.orders.show');
    Route::get('/siparis/{code}', '\App\Http\Controllers\Admin\OrderController@showOrder')->name('admin.order.show');
    # ADMIN POST ROUTES
    Route::post('/giris', '\App\Http\Controllers\Admin\AdminLoginController@loginForm')->name('admin.login.submit');
    Route::post('/blog/olustur', '\App\Http\Controllers\Admin\AdminController@blogCreate');
    Route::post('/kategoriler', '\App\Http\Controllers\Admin\CategoryController@addCategory');
    Route::post('/kategoriler/{slug}', '\App\Http\Controllers\Admin\CategoryController@editCategory');
    Route::post('/urunler/ekle', '\App\Http\Controllers\Admin\ProductController@addProduct');
    Route::post('/ayarlar/anasayfa', '\App\Http\Controllers\Admin\AdminController@settingHomePagePost');
    Route::post('/duyuru', function() {
        broadcast(new MakeAnnuncement(request('title'), request('message')));
        return view('back-end.announcement.announcement');
    });
    Route::post('/indirim/yeni', '\App\Http\Controllers\Admin\AdminController@applyDiscount');
    Route::post('/siparis/{code}', '\App\Http\Controllers\Admin\OrderController@updateOrder');
    Route::post('/urun/duzenle/{code}', '\App\Http\Controllers\Admin\ProductController@editProduct');

});
Route::get('/', '\App\Http\Controllers\HomePageController@index')->name('index');
Route::post('/', '\App\Http\Controllers\HomePageController@index');
Route::get('/login', '\App\Http\Controllers\UserController@loginIndex')->name('authenticate.login');
Route::get('/register', '\App\Http\Controllers\UserController@registerIndex')->name('authenticate.register');
Route::post('/register/create', '\App\Http\Controllers\UserController@registerCustomer');
Route::post('/login/customer', '\App\Http\Controllers\UserController@loginCustomer');

Route::get('/customer/forgetpassword', '\App\Http\Controllers\UserController@forgetPassword')->name('customer.forgetpassword');
Route::get('/customer/logout', function () {
    if (Auth::check()){
        Auth::logout();
        return redirect()->route('authenticate.login');
    }
})->name('authenticate.logout');
Route::post('/customer/forgetpassword/send', '\App\Http\Controllers\UserController@sendResetPasswordMail');
Route::get('/customer/resetpassword/{reset_token}', '\App\Http\Controllers\UserController@resetPasswordView')->name('customer.resetpassword');
Route::post('/customer/resetpassword/reset', '\App\Http\Controllers\UserController@resetPassword');
Route::get('/profil', '\App\Http\Controllers\UserController@profileIndex')->name('customer.profile');
Route::get('/blog', '\App\Http\Controllers\BlogController@blogList')->name('blog.list');
Route::get('/blog/{slug}', '\App\Http\Controllers\BlogController@showBlog')->name('blog.showblog');
Route::post('/blog/{slug}', '\App\Http\Controllers\BlogController@leaveComment');
Route::get('/{category_slug}', 'App\Http\Controllers\CategoryController@listProducts')->name('category.list');
Route::get('/{category_slug}/{product_slug}', 'App\Http\Controllers\ProductController@showProduct')->name('product.show');
Route::post('/{category_slug}/{product_slug}', 'App\Http\Controllers\ProductController@addToCart');
Route::post('/{category_slug}/{product_slug}/degerlendirme', 'App\Http\Controllers\ProductController@makeReview');
