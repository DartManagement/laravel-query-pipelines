<?php

declare(strict_types=1);

namespace SimonAnkele\LaravelQueryPipelines\Filters;

use SimonAnkele\LaravelQueryPipelines\BaseFilter;
use SimonAnkele\LaravelQueryPipelines\Enums\TrashOptionEnum;

class TrashFilter extends BaseFilter
{
    public function __construct(protected ?string $field = 'trashed')
    {
        parent::__construct();
    }

    public static function make($field = 'trashed'): self
    {
        return new self($field);
    }

    protected function apply(): static
    {
        $option = TrashOptionEnum::tryFrom($this->getSearchValue()[0]);
        match ($option) {
            TrashOptionEnum::ONLY => $this->query->onlyTrashed(), // @phpstan-ignore-line
            TrashOptionEnum::WITH => $this->query->withTrashed(), // @phpstan-ignore-line
            default => $this->query,
        };

        return $this;
    }
}
