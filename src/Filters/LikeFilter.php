<?php

declare(strict_types=1);

namespace SimonAnkele\LaravelQueryPipelines\Filters;

use SimonAnkele\LaravelQueryPipelines\BaseFilter;
use SimonAnkele\LaravelQueryPipelines\Enums\WildcardPosition;

class LikeFilter extends BaseFilter
{
    private bool $all = false;

    private WildcardPosition $wildcardPosition = WildcardPosition::BOTH;

    /**
     * @param  array<string>  ...$columns
     */
    public function __construct(array $columns)
    {
        parent::__construct();

        $this->columns = $columns;
    }

    public static function columns(string ...$columns): self
    {
        return new self($columns);
    }

    public function all(): self
    {
        $this->all = true;

        return $this;
    }

    public function wildcard(WildcardPosition $wildcardPosition): self
    {
        $this->wildcardPosition = $wildcardPosition;

        return $this;
    }

    protected function apply(): static
    {
        $this->all
            ? $this->useWhereAll()
            : $this->useWhereAny();

        return $this;
    }

    private function useWhereAny(): void
    {
        $this->query->whereAny($this->columns, 'like', $this->resolveWildcard('Example'));
    }

    private function useWhereAll(): void
    {
        $this->query->whereAll($this->columns, 'like', $this->resolveWildcard('Example'));
    }

    private function resolveWildcard(string $value): string
    {
        return match ($this->wildcardPosition) {
            WildcardPosition::RIGHT => "$value%",
            WildcardPosition::LEFT => "%$value",
            default => "%$value%",
        };
    }
}
