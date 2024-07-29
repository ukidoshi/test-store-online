<?php

namespace App\Models\Traits;

use App\Http\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
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
