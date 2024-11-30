<?php

declare(strict_types=1);

namespace SimonAnkele\LaravelQueryPipelines\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

trait HasFilterableQueryPipeline
{
    public function scopeSort(Builder $query, ?array $criteria = null): Builder
    {
        $criteria = is_null($criteria) ? $this->sortCriteria() : $criteria;

        return app(Pipeline::class)
            ->send($query)
            ->through($criteria)
            ->thenReturn();
    }

    public function sortCriteria(): array
    {
        if (method_exists($this, 'getSorts')) {
            return $this->getSorts();
        }

        return [];
    }
}
