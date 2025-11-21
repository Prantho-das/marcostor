<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with(['images', 'brand', 'category'])->findOrFail($id);
        return view('product-details', compact('product'));
    }

     // 🔹 main page
    public function newArrivalsPage()
    {
        // সর্বশেষ ২৪টা product লোড
        $products = Product::orderBy('created_at', 'desc')->take(24)->get();

        return view('pages.new-arrivals-page', compact('products'));
    }

    // 🔹 AJAX Load More
    public function loadMoreNewArrivals(Request $request)
    {
        $skip = $request->input('skip', 0);
        $take = 12; // প্রতিবার ১২টা করে load হবে

        $products = Product::orderBy('created_at', 'desc')
            ->skip($skip)
            ->take($take)
            ->get();

        // partial HTML ফেরত দিবো
        $html = view('partials.new-arrivals-items', compact('products'))->render();

        return response()->json(['html' => $html, 'count' => $products->count()]);
    }


  public function superDealsPage()
{
    $products = Product::where('is_active', 1)
        ->whereNotNull('discount_price')
        ->orderBy('created_at', 'desc')
        ->take(24)
        ->get();

    return view('pages.super-deals-view-all', compact('products'));
}

public function loadMoreSuperDeals(Request $request)
{
    $skip = $request->input('skip', 0);
    $take = 12;

    $products = Product::where('is_active', 1)
        ->whereNotNull('discount_price')
        ->orderBy('created_at', 'desc')
        ->skip($skip)
        ->take($take)
        ->get();

    $html = view('partials.super-deals-items', compact('products'))->render();

    return response()->json(['html' => $html, 'count' => $products->count()]);
}


    

    
}
