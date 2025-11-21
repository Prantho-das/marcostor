<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\SectionCategorySetting;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
public function index()
{
    // ✅ Parent and Sub Categories for navigation data displaye in shop by category
    $parentCategories = Category::where('status', 1)
                                ->whereNull('parent_id')
                                ->orderBy('name')
                                ->get();

    $subCategories = Category::where('status', 1)
                             ->whereNotNull('parent_id')
                             ->orderBy('name')
                             ->get() ?? collect(); // ❌ empty collection default

    // ✅ Latest 10 new arrival products
    $newArrivals = Product::where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

     // ✅ Super Deals (যাদের discount_price null নয়)
    $superDeals = Product::where('is_active', 1)
        ->whereNotNull('discount_price')
        ->orderBy('created_at', 'desc')
        ->take(10)
        ->get();

     // admin-selected category IDs আনো
    $bagsCat = SectionCategorySetting::where('section_name', 'bags')->value('category_id');
    $bagsCategory = Category::find($bagsCat);

    $coversCat = SectionCategorySetting::where('section_name', 'covers')->value('category_id');
    $coversCategory = Category::find($coversCat);

    $soundCat = SectionCategorySetting::where('section_name', 'sound')->value('category_id');
    $soundCategory = Category::find($soundCat);

    // products আনো
    $bagsProducts = Product::where('category_id', $bagsCat)->take(12)->get();
    $coverProducts = Product::where('category_id', $coversCat)->take(12)->get();
    $soundProducts = Product::where('category_id', $soundCat)->take(12)->get();

    

    return view('home', compact(
        'parentCategories', 
        'subCategories', 
        'newArrivals', 
        'superDeals', 
        'bagsProducts', 
        'coverProducts', 
        'soundProducts',
        'bagsCategory',
        'coversCategory',
        'soundCategory'
    ));
}



}
