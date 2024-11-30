<?php

declare(strict_types=1);

namespace SimonAnkele\LaravelQueryPipelines\Filters;

use SimonAnkele\LaravelQueryPipelines\BaseFilter;
use SimonAnkele\LaravelQueryPipelines\Enums\WildcardPositionEnum;

class RelativeFilter extends BaseFilter
{
    private mixed $wildcardPosition;

    public function __construct(protected ?string $field, WildcardPositionEnum|string|null $wildcardPosition = null)
    {
        parent::__construct();

        if (is_null($wildcardPosition)) {
            $wildcardPosition = config(
                key: 'query-pipelines.relative_wildcard_position',
                default: WildcardPositionEnum::BOTH
            );
        }
        if (! $wildcardPosition instanceof WildcardPositionEnum) {
            $wildcardPosition = WildcardPositionEnum::from($wildcardPosition);
        }
        $this->wildcardPosition = $wildcardPosition;
    }

    public static function make($field, WildcardPositionEnum|string|null $wildcardPosition = null)
    {
        return new self($field, $wildcardPosition);
    }

    protected function apply(): static
    {
        foreach ($this->getSearchValue() as $value) {
            $this->query->where($this->getSearchColumn(), 'like', $this->computeSearchValue($value));
        }

        return $this;
    }

    private function computeSearchValue($value): string
    {
        return match ($this->wildcardPosition) {
            WildcardPositionEnum::RIGHT => "$value%",
            WildcardPositionEnum::LEFT => "%$value",
            default => "%$value%",
        };
    }
}
