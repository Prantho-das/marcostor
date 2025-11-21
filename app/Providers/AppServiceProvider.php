<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; 
use App\Models\Category;
use Illuminate\Pagination\Paginator;
use App\Models\Cart;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    
        Paginator::useBootstrap();
        
        // Share $categories with desktop-navbar on every view
        View::composer('partials.desktop-navbar', function ($view) {
        $categories = Category::with('children.children')
                        ->whereNull('parent_id')
                        ->get();

        $view->with('categories', $categories);

    });

        View::composer('partials.sidebar-categories', function ($view) {
        $categories = \App\Models\Category::with('children.children')
                        ->whereNull('parent_id')
                        ->get();

        $view->with('categories', $categories);
    });



        // ✅ Global cart count share for footer/mobile nav
View::composer(['partials.header', 'partials.footer'], function ($view) {
    $cartCount = 0;

    if (auth()->check()) {
        $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
    } else {
        $cart = session('cart', []);
        $cartCount = count($cart);
    }

    $view->with('cartCount', $cartCount);
});


    }
}