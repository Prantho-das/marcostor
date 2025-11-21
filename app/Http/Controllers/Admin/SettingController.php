<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SectionCategorySetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        // current settings আনবে
        $settings = SectionCategorySetting::pluck('category_id', 'section_name')->toArray();

        return view('admin.settings.index', compact('categories', 'settings'));
    }

    public function update(Request $request)
    {
        $data = [
            'bags' => $request->bags,
            'covers' => $request->covers,
            'sound' => $request->sound,
        ];

        foreach ($data as $section => $catId) {
            SectionCategorySetting::updateOrCreate(
                ['section_name' => $section],
                ['category_id' => $catId]
            );
        }

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
