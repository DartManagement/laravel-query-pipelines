<?php

declare(strict_types=1);

namespace SimonAnkele\LaravelQueryPipelines\Filters;

use Illuminate\Support\Str;
use SimonAnkele\LaravelQueryPipelines\BaseFilter;

class RelationFilter extends BaseFilter
{
    private $relation;

    public function __construct($relation, protected ?string $field)
    {
        parent::__construct();
        $this->relation = $relation;
    }

    public static function make($relation, $field): self
    {
        return new self($relation, $field);
    }

    protected function getFilterName(): string
    {
        return "{$this->detector}{$this->relation}_{$this->field}";
    }

    protected function apply(): static
    {
        $searchValue = $this->getSearchValue();
        $this->relation = Str::camel($this->relation);
        $this->query->whereHas($this->relation, function ($query) use ($searchValue) {
            $query->whereIn($this->getSearchColumn(), $searchValue);
        });

        return $this;
    }
}
