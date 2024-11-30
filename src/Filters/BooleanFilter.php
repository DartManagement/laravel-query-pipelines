<?php

declare(strict_types=1);

namespace SimonAnkele\LaravelQueryPipelines\Filters;

use SimonAnkele\LaravelQueryPipelines\BaseFilter;

class BooleanFilter extends BaseFilter
{
    public function __construct(protected ?string $field)
    {
        parent::__construct();
    }

    public static function make($field)
    {
        return new self($field);
    }

    protected function apply(): static
    {
        foreach ($this->getSearchValue() as $value) {
            $this->query->where($this->getSearchColumn(), $value ? true : false);
        }

        return $this;
    }
}
