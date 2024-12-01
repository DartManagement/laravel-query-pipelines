<?php

declare(strict_types=1);

namespace SimonAnkele\LaravelQueryPipelines\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Pipeline;

trait Filterable
{
    /**
     * @param  Builder<$this>  $query
     * @param  array<string>  $criteria
     */
    public function scopeFilter(Builder $query, array $criteria): mixed
    {
        return Pipeline::send($query)
            ->through($criteria)
            ->thenReturn();
    }
}
