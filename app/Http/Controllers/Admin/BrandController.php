<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use DB;

class BrandController extends Controller
{
    // index page
    public function index(Request $request)
    {
        $query = Brand::query()->orderBy('created_at', 'desc');

        if ($request->filled('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        $brands = $query->paginate(15);

        return view('admin.brands.index', compact('brands'));
    }

    // create form
    public function create()
    {
        return view('admin.brands.create');
    }

    // store brand
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:brands,slug',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only(['name', 'slug']);
            $data['slug'] = $data['slug'] ?: Str::slug($data['name']);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('brands', $filename, 'public');
                $data['image'] = $path;
            }

            Brand::create($data);

            DB::commit();
            return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }
    }

    // edit form
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    // update brand
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:brands,slug,' . $brand->id,
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only(['name', 'slug']);
            $data['slug'] = $data['slug'] ?: Str::slug($data['name']);

            if ($request->hasFile('image')) {
                if ($brand->image && Storage::disk('public')->exists($brand->image)) {
                    Storage::disk('public')->delete($brand->image);
                }
                $file = $request->file('image');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('brands', $filename, 'public');
                $data['image'] = $path;
            }

            $brand->update($data);

            DB::commit();
            return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }
    }

    // delete brand
    public function destroy(Brand $brand)
    {
        if ($brand->image && Storage::disk('public')->exists($brand->image)) {
            Storage::disk('public')->delete($brand->image);
        }

        $brand->delete();
        return back()->with('success', 'Brand deleted successfully!');
    }
}
