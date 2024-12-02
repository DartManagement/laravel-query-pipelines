<?php

declare(strict_types=1);

namespace DartManagement\LaravelQueryPipelines;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Override;

abstract class BaseFilter extends BasePipeline
{
    /**
     * @var array<string>
     */
    protected array $columns = [];

    protected ?string $queryParameter = null;

    private mixed $value;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param  Builder<Model>  $query
     * @return Builder<Model>
     */
    #[Override]
    public function handle(Builder $query, Closure $next): Builder
    {
        $this->query = $query;

        $this->apply();

        return $next($query);
    }

    public function value(mixed $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function queryParameter(string $queryParameter): static
    {
        $this->queryParameter = $queryParameter;

        return $this;
    }

    protected function searchValue(): mixed
    {
        if ($this->request === null) {
            throw new InvalidArgumentException('Request object is not set.');
        }

        return $this->value ?? $this->request->input($this->queryParameter);
    }
}
