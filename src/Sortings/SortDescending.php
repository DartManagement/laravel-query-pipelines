<?php

declare(strict_types=1);

namespace SimonAnkele\LaravelQueryPipelines\Sortings;

use SimonAnkele\LaravelQueryPipelines\BaseSorting;

class SortDescending extends BaseSorting
{
    public static function make(): self
    {
        return new self;
    }

    protected function apply(): static
    {
        foreach ($this->sort as $field) {
            $this->query->orderBy($field, 'desc');
        }

        return $this;
    }
}
