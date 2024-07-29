<?php

namespace App\Models;

use App\Http\Filters\QueryFilter;
use App\Models\Traits\Filterable;
use App\Models\Traits\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasSlug, Filterable;

    protected $guarded = false;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attributes()
    {
        return $this->hasOne(ProductAttribute::class);
    }

    /**
     * Трейт для динамической фильтрации моделей
     * @param Builder $builder
     * @param QueryFilter $filter
     * @return void
     */
    public function scopeFilter(Builder $builder, QueryFilter $filter): void
    {
        $filter->apply($builder);
    }
}
