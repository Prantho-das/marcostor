<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Frontend\CategoryController as FrontCategoryController;
use App\Http\Controllers\Frontend\ProductController as FrontProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DeliveryController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

// Route::get('/', function() {
//     return view('home');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();
//home route



Route::get('/cache-clear', function () {
    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');
    return response(['message' => "Cache Clear"]);
});
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Google OAuth routes
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// frontend category route
Route::get('/category/{slug}', [FrontCategoryController::class, 'show'])->name('category.show');

//view all and filter products route
Route::get('/category', function () {
    return view('category');
})->name('bags.page');


// ðŸ‘‡ New Arrivals Full Page Route
Route::get('/new-arrivals', [App\Http\Controllers\Frontend\ProductController::class, 'newArrivalsPage'])->name('new.arrivals.page');

// AJAX for Load More
Route::get('/new-arrivals/load-more', [App\Http\Controllers\Frontend\ProductController::class, 'loadMoreNewArrivals'])->name('new.arrivals.loadMore');

// ðŸ‘‡ Super Deals Full Page Route
Route::get('/super-deals', [FrontProductController::class, 'superDealsPage'])->name('super.deals');
// AJAX for Load More
Route::get('/super-deals/load-more', [FrontProductController::class, 'loadMoreSuperDeals'])->name('super.deals.loadMore');

// frontend product details route
Route::get('/product/{id}', [FrontProductController::class, 'show'])->name('product.details');

// all cart route
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

//route to fetch cart data (for sidebar)
Route::get('/cart/fetch', [CartController::class, 'fetch'])->name('cart.fetch');

// route to get cart count
Route::get('/cart/count', [App\Http\Controllers\CartController::class, 'count'])->name('cart.count');

// checkout route (protected)
Route::middleware(['auth'])->group(function () {

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
});

// SSLCommerz Callbacks (must be public)
Route::match(['get', 'post'], '/checkout/success', [CheckoutController::class, 'success'])
    ->withoutMiddleware([VerifyCsrfToken::class])

    ->name('checkout.success');
Route::match(['get', 'post'], '/checkout/fail', [CheckoutController::class, 'fail'])->withoutMiddleware([VerifyCsrfToken::class])->name('checkout.fail');
Route::match(['get', 'post'], '/checkout/cancel', [CheckoutController::class, 'cancel'])->withoutMiddleware([VerifyCsrfToken::class])->name('checkout.cancel');
Route::post('/checkout/ipn', [CheckoutController::class, 'ipn'])->withoutMiddleware([VerifyCsrfToken::class])->name('checkout.ipn');





//static routes
Route::get('/about-us', function () {
    return view('static.about');
})->name('about');

//contaict us
Route::get('/contact-us', function () {
    return view('static.contact');
})->name('contact');

// privacy policy
Route::get('/privacy-policy', function () {
    return view('static.privacy-policy');
})->name('privacy.policy');

// terms and conditions
Route::get('/terms-and-conditions', function () {
    return view('static.terms-conditions');
})->name('terms.conditions');



// ðŸ§­ Admin routes (auth + admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // route admin dashboard
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // product routes
    Route::resource('products', ProductController::class);


    // product image delete
    Route::delete('/products/image/{id}', [App\Http\Controllers\Admin\ProductController::class, 'deleteImage'])
        ->name('admin.products.image.destroy');



    //category routes
    Route::resource('categories', CategoryController::class);

    // brand routes
    Route::resource('brands', BrandController::class);
    // color routes
    Route::resource('colors', ColorController::class);

    // settings routes
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');

    Route::post('/tinymce/upload', [\App\Http\Controllers\Admin\ProductController::class, 'tinymceUpload'])
        ->name('tinymce.upload')
        ->middleware('auth', 'can:manage-products'); // adjust middleware

    // order routes
    Route::resource('orders', OrderController::class);




Route::prefix('delivery')->group(function () {

    // List all couriers
    Route::get('couriers', [App\Http\Controllers\Admin\CourierController::class, 'index']);

    // Get cities by courier (all have cities)
    Route::get('{courier}/cities', [App\Http\Controllers\Admin\CourierController::class, 'getCities']);

    // Get zones by courier and city (zones optional, might return empty)
    Route::get('{courier}/zones/{cityId}', [App\Http\Controllers\Admin\CourierController::class, 'getZones']);

    // Get areas by courier and zone or city
    // Some couriers may skip zone and get areas by city, so use optional param
    Route::get('{courier}/areas/{parentId}', [App\Http\Controllers\Admin\CourierController::class, 'getAreas']);

    // Create a store (POST)
    Route::post('{courier}/stores', [App\Http\Controllers\Admin\CourierController::class, 'createStore']);

    // Create order (POST)
    Route::post('{courier}/orders', [App\Http\Controllers\Admin\CourierController::class, 'createOrder']);

    // Bulk order creation (POST)
    Route::post('{courier}/orders/bulk', [App\Http\Controllers\Admin\CourierController::class, 'createBulkOrders']);

    // Optional: Price calculation (POST)
    Route::post('{courier}/price-calc', [App\Http\Controllers\Admin\CourierController::class, 'calculatePrice']);
});

});
