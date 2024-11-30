<?php

declare(strict_types=1);

namespace SimonAnkele\LaravelQueryPipelines\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface Sortable
{
    public function scopeSort(Builder $query, ?array $criteria = null): Builder;

    public function sortCriteria(): array;
}
