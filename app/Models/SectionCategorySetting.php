<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionCategorySetting extends Model
{
    protected $fillable = ['section_name', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
