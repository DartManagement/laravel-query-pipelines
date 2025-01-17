<?php

declare(strict_types=1);

namespace DartManagement\LaravelQueryPipelines\Filters;

use Carbon\Exceptions\InvalidTypeException;
use DartManagement\LaravelQueryPipelines\BaseFilter;
use DartManagement\LaravelQueryPipelines\Enums\WhereType;
use DartManagement\LaravelQueryPipelines\Enums\WildcardPosition;
use InvalidArgumentException;

class LikeFilter extends BaseFilter
{
    private WhereType $whereType = WhereType::ANY;

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
        $this->whereType = WhereType::ALL;

        return $this;
    }

    public function wildcard(WildcardPosition $wildcardPosition): self
    {
        $this->wildcardPosition = $wildcardPosition;

        return $this;
    }

    protected function apply(): static
    {

        $this->whereType === WhereType::ALL
            ? $this->useWhereAll()
            : $this->useWhereAny();

        return $this;
    }

    private function useWhereAny(): void
    {
        $this->query->whereAny($this->columns, 'like', $this->resolveWildcard($this->searchValue()));
    }

    private function useWhereAll(): void
    {
        $this->query->whereAll($this->columns, 'like', $this->resolveWildcard($this->searchValue()));
    }

    private function resolveWildcard(mixed $value): string
    {
        if ($value === null) {
            throw new InvalidArgumentException('Request object is not set.');
        }

        if ( !(gettype($value) === 'string' || gettype($value) === 'integer' || gettype($value) === 'double') ) {
            throw new InvalidTypeException('Value for wildcard not accepted.');
        }

        return match ($this->wildcardPosition) {
            WildcardPosition::RIGHT => "{$value}%",
            WildcardPosition::LEFT => "%{$value}",
            default => "%$value%",
        };
    }
}
