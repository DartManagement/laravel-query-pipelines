<?php

declare(strict_types=1);

namespace SimonAnkele\LaravelQueryPipelines\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface Filterable
{
    public function scopeFilter(Builder $query, ?array $criteria = null): Builder;

    public function filterCriteria(): array;
}
