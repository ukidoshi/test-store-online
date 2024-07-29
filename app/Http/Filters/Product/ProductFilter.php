<?php

namespace App\Http\Filters\Product;

use App\Http\Filters\QueryFilter;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use JetBrains\PhpStorm\NoReturn;

class ProductFilter extends QueryFilter
{
    public function price_from(float $value): void
    {
        $this->builder->where('price', '>=', $value);
    }

    public function price_to(float $value): void
    {
        $this->builder->where('price', '<=', $value);
    }

    public function category_id(string $value): void
    {
        $this->builder->where('category_id', '=', $value);
    }

    public function quantity(int $value): void
    {
        $this->builder->whereHas('attributes', function (Builder $query) use ($value) {
            $query->where('quantity', '=', $value);
        });
    }

    public function width(int $value): void
    {
        $this->builder->whereHas('attributes', function (Builder $query) use ($value) {
            $query->where('width', '=', $value);
        });
    }

    public function length(int $value): void
    {
        $this->builder->whereHas('attributes', function (Builder $query) use ($value) {
            $query->where('length', '=', $value);
        });
    }

    public function weight(int $value): void
    {
        $this->builder->whereHas('attributes', function (Builder $query) use ($value) {
            $query->where('weight', '=', $value);
        });
    }
}
