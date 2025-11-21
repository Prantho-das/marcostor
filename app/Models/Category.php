<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','slug','parent_id','description','status', 'image'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class,'parent_id');
    }

    //helper function to build tree dropdown
    public static function treeList($categories, $parent_id = null, $prefix = '')
    {
        $result = [];
        foreach ($categories->where('parent_id', $parent_id) as $category) {
            $result[$category->id] = $prefix . $category->name;
            $result += self::treeList($categories, $category->id, $prefix . '— ');
        }
        return $result;
    }

    public function imageUrl($size = null)
{
    if (! $this->image) return null;

    // if you store thumbnails under categories/thumbs/{size}_name.jpg you can map here
    if ($size) {
        return asset('storage/' . $this->image); // adjust if you save size-specific
    }

    return asset('storage/' . $this->image);
}


}
