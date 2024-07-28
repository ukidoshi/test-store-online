<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id'];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getCategoryDepth(): int
    {
        $depth = 0;
        $currentCategory = $this;

        while ($currentCategory->parent) {
            $depth++;
            $currentCategory = $currentCategory->parent;
        }

        return $depth;
    }
}
