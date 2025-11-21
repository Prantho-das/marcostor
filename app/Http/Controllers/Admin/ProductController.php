<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Log;

use Spatie\ImageOptimizer\OptimizerChainFactory;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Purifier;
use DB;

class ProductController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('images','category')->orderBy('created_at','desc');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('name','like', "%{$q}%");
        }

        $products = $query->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', true)->get();
        $brands = Brand::all();
        $colors = Color::all();
        return view('admin.products.create', compact('categories','brands','colors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        DB::beginTransaction();
        try {
            //  Log::info('🟢 Product store started', $request->all());
            $data = $request->only(['name','slug','description','price','discount_price','stock','category_id', 'brand_id']);
            $data['description'] = $request->filled('description') ? Purifier::clean($request->input('description')) : null;
            $data['is_active'] = $request->has('is_active'); // checked হলে true, না হলে false

            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']).'-'.Str::random(4);
            }
            $product = Product::create($data);
            // dd($product);

            //  Log::info('🟠 Product created', ['product' => $product]);

            // attach colors
            if($request->filled('colors')){
                $product->colors()->sync($request->colors);
                //  Log::info('🟣 Colors synced', ['colors' => $request->colors]);
            }

           if ($request->hasFile('images')) {
                $manager = new ImageManager(new Driver());
                $optimizerChain = OptimizerChainFactory::create();

                foreach ($request->file('images') as $index => $file) {
                    // unique name
                    $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                    $ext = $file->getClientOriginalExtension();

                    // file paths
                    $basePath = "products/{$product->id}";
                    $originalPath = "{$basePath}/original/{$filename}.{$ext}";
                    $processedPath = "{$basePath}/processed/{$filename}.webp";
                    $thumbPath = "{$basePath}/thumbs/{$filename}_300.webp";

                    // save original
                    $file->storeAs("{$basePath}/original", "{$filename}.{$ext}", 'public');

                    // optimize original
                    $optimizerChain->optimize(storage_path("app/public/{$originalPath}"));

                    // resize to 1200px & save as webp
                    $image = $manager->read(storage_path("app/public/{$originalPath}"))
                        ->resize(1200, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });

                    Storage::disk('public')->put(
                        $processedPath,
                        (string) $image->encodeByExtension('webp', quality: 75)
                    );

                    // make 300x300 thumbnail
                    $thumb = $manager->read(storage_path("app/public/{$originalPath}"))
                        ->cover(300, 300);

                    Storage::disk('public')->put(
                        $thumbPath,
                        (string) $thumb->encodeByExtension('webp', quality: 75)
                    );

                    // Save optimized image path in DB
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $processedPath, // main display image
                        'is_primary' => $index === 0,
                    ]);
                }
            }


            DB::commit();
            // Log::info('✅ Product store committed successfully');

            return redirect()->route('admin.products.index')->with('success','Product created');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error('❌ Product store failed: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('status', true)->get();
        $brands = Brand::all();
        $colors = Color::all();
        $product->load('images','colors');
        return view('admin.products.edit', compact('product','categories','brands','colors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)

    
    {
        //   dd('Update method hit', $product->id, $request->all());
        DB::beginTransaction();
        try {
            $data = $request->only([
                'name','slug','description','price','discount_price',
                'stock','category_id', 'brand_id'
            ]);

            // handle slug
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']).'-'.Str::random(4);
            }

            

            // handle is_active
            $data['is_active'] = $request->has('is_active');

            // update product
            $product->update($data);

            // sync colors
            if($request->filled('colors')){
                $product->colors()->sync($request->colors);
            } else {
                $product->colors()->sync([]); // remove all if none selected
            }

            // add new images
if ($request->hasFile('images')) {
    $manager = new ImageManager(new Driver());
    $optimizerChain = OptimizerChainFactory::create();

    foreach ($request->file('images') as $index => $file) {
        // unique name
        $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $ext = $file->getClientOriginalExtension();

        // file paths
        $basePath = "products/{$product->id}";
        $originalPath = "{$basePath}/original/{$filename}.{$ext}";
        $processedPath = "{$basePath}/processed/{$filename}.webp";
        $thumbPath = "{$basePath}/thumbs/{$filename}_300.webp";

        // save original
        $file->storeAs("{$basePath}/original", "{$filename}.{$ext}", 'public');

        // optimize original
        $optimizerChain->optimize(storage_path("app/public/{$originalPath}"));

        // resize to 1200px & save as webp
        $image = $manager->read(storage_path("app/public/{$originalPath}"))
            ->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

        Storage::disk('public')->put(
            $processedPath,
            (string) $image->encodeByExtension('webp', quality: 75)
        );

        // make 300x300 thumbnail
        $thumb = $manager->read(storage_path("app/public/{$originalPath}"))
            ->cover(300, 300);

        Storage::disk('public')->put(
            $thumbPath,
            (string) $thumb->encodeByExtension('webp', quality: 75)
        );

        // Save optimized image path in DB
        ProductImage::create([
            'product_id' => $product->id,
            'image_path' => $processedPath, // main display image
            'is_primary' => $index === 0,
        ]);
    }
}


            DB::commit();
            return redirect()->route('admin.products.index')->with('success','Product updated');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
       // delete images from storage
        foreach ($product->images as $img) {
            if (Storage::disk('public')->exists($img->image_path)) {
                Storage::disk('public')->delete($img->image_path);
            }
        }
        $product->delete();
        return back()->with('success','Product deleted');
    }


    
    public function tinymceUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);

        $file = $request->file('file');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public/tinymce', $filename); // storage/app/public/tinymce
        $url = Storage::url($path); // /storage/tinymce/.... (ensure symlink)

        return response()->json(['location' => $url]); // TinyMCE expects this
    }

    public function deleteImage($id)
    {
        try {
            $image = ProductImage::findOrFail($id);

            // image file delete from storage
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }

            // database record delete
            $image->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


}