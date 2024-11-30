<?php

declare(strict_types=1);

namespace SimonAnkele\LaravelQueryPipelines\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

trait HasSortableQueryPipeline
{
    public function scopeFilter(Builder $query, ?array $criteria = null): Builder
    {
        $criteria = is_null($criteria) ? $this->filterCriteria() : $criteria;

        return app(Pipeline::class)
            ->send($query)
            ->through($criteria)
            ->thenReturn();
    }

    public function filterCriteria(): array
    {
        if (method_exists($this, 'getFilters')) {
            return $this->getFilters();
        }

        return [];
    }
}
