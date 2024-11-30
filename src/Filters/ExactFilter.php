<?php

declare(strict_types=1);

namespace SimonAnkele\LaravelQueryPipelines\Filters;

use SimonAnkele\LaravelQueryPipelines\BaseFilter;

class ExactFilter extends BaseFilter
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
        $this->query->whereIn($this->getSearchColumn(), $this->getSearchValue());

        return $this;
    }
}
