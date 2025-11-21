<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // 👈 add this line


// use Intervention\Image\ImageManagerStatic as Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('children.children')
            ->whereNull('parent_id')
            ->orderBy('id')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $parents = Category::treeList($categories);
        return view('admin.categories.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */


public function store(StoreCategoryRequest $request)
{
    $data = $request->only(['name','slug','parent_id','description']);

    // Generate slug if empty
    if (empty($data['slug'])) {
        $data['slug'] = Str::slug($data['name']);
    }

    // Initialize ImageManager
    $manager = new ImageManager(new Driver());

    if ($request->hasFile('image')) {
        $file = $request->file('image');

        // Create unique filename
        $filename = time().'_'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $ext = $file->getClientOriginalExtension();
        $originalPath = "categories/original/{$filename}.{$ext}";

        // Save original image
        $file->storeAs('categories/original', "{$filename}.{$ext}", 'public');

        // Optimize original image
        $optimizerChain = OptimizerChainFactory::create();
        $optimizerChain->optimize(storage_path("app/public/{$originalPath}"));

        // Generate WebP version (resize to max width 1200px)
        $image = $manager->read(storage_path("app/public/{$originalPath}"))
            ->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

        $webpPath = "categories/processed/{$filename}.webp";
        Storage::disk('public')->put(
            $webpPath,
            (string) $image->encodeByExtension('webp', quality: 75)
        );

        // Generate thumbnail (300x300 crop)
        $thumb = $manager->read(storage_path("app/public/{$originalPath}"))
            ->cover(300, 300);

        $thumbPath = "categories/thumbs/{$filename}_300.webp";
        Storage::disk('public')->put(
            $thumbPath,
            (string) $thumb->encodeByExtension('webp', quality: 75)
        );

        // Save final webp path to database
        $data['image'] = $webpPath;
    }

    // Create category
    Category::create($data);

    return redirect()
        ->route('admin.categories.index')
        ->with('success', 'Category created successfully');
}


public function update(UpdateCategoryRequest $request, Category $category)
{
    $data = $request->only(['name','slug','parent_id','description']);

    // Generate slug if empty
    if (empty($data['slug'])) {
        $data['slug'] = Str::slug($data['name']);
    }

    // Initialize ImageManager
    $manager = new ImageManager(new Driver());

    if ($request->hasFile('image')) {
        // Delete old images if exist
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $file = $request->file('image');
        $filename = time().'_'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $ext = $file->getClientOriginalExtension();
        $originalPath = "categories/original/{$filename}.{$ext}";

        // Save original
        $file->storeAs('categories/original', "{$filename}.{$ext}", 'public');

        // Optimize original
        $optimizerChain = OptimizerChainFactory::create();
        $optimizerChain->optimize(storage_path("app/public/{$originalPath}"));

        // Generate optimized WebP
        $image = $manager->read(storage_path("app/public/{$originalPath}"))
            ->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

        $webpPath = "categories/processed/{$filename}.webp";
        Storage::disk('public')->put(
            $webpPath,
            (string) $image->encodeByExtension('webp', quality: 75)
        );

        // Generate thumbnail
        $thumb = $manager->read(storage_path("app/public/{$originalPath}"))
            ->cover(300, 300);

        $thumbPath = "categories/thumbs/{$filename}_300.webp";
        Storage::disk('public')->put(
            $thumbPath,
            (string) $thumb->encodeByExtension('webp', quality: 75)
        );

        // Save final image path to database
        $data['image'] = $webpPath;
    }

    // Update category
    $category->update($data);

    return redirect()
        ->route('admin.categories.index')
        ->with('success', 'Category updated successfully');
}




    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)->orderBy('name')->get();
        $parents = Category::treeList($categories);
        return view('admin.categories.edit', compact('category', 'parents'));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success','Category deleted');
    }
}
