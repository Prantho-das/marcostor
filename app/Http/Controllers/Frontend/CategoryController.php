<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Color;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Show products under a specific category or subcategory.
     */
 public function show(Request $request, $slug)
    {
        // Category খুঁজে বের করো
        $category = Category::where('slug', $slug)->firstOrFail();

        // Filter Inputs
        $brandId = $request->get('brand');
        $colorId = $request->get('color');
        $minPrice = $request->get('min_price', 0);
        $maxPrice = $request->get('max_price', 999999);

        // Base Query
        $products = Product::where('is_active', true)
            ->where('category_id', $category->id)
            ->when($brandId, fn($q) => $q->where('brand_id', $brandId))
            ->when($colorId, fn($q) => $q->whereHas('colors', fn($c) => $c->where('colors.id', $colorId)))
            ->whereBetween('price', [$minPrice, $maxPrice])
            ->with(['brand', 'mainImage'])
            ->paginate(12);

        // Filters data
        $brands = Brand::orderBy('name')->get();
        $colors = Color::orderBy('name')->get();

        return view('category', compact('category', 'products', 'brands', 'colors'));
    }
    /**
     * Helper function to get all nested category IDs (recursive)
     */
    private function getAllCategoryIds($category)
    {
        $ids = [$category->id];

        foreach ($category->children as $child) {
            $ids = array_merge($ids, $this->getAllCategoryIds($child));
        }

        return $ids;
    }
}
