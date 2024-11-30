<?php

declare(strict_types=1);

namespace SimonAnkele\LaravelQueryPipelines\Filters;

use SimonAnkele\LaravelQueryPipelines\BaseFilter;

class BitwiseFilter extends BaseFilter
{
    public function __construct(protected ?string $field)
    {
        parent::__construct();
    }

    public static function make($field): self
    {
        return new self($field);
    }

    protected function apply(): static
    {
        $flag = null;
        foreach ($this->getSearchValue() as $value) {
            $flag ??= intval($value);
            $flag = intval($flag) | intval($value);
        }
        if ($flag === null) {
            return $this;
        }
        $this->query->whereRaw("{$this->getSearchColumn()} & ? = ?", [$flag, $flag]);

        return $this;
    }
}
