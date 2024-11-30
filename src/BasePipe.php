<?php

declare(strict_types=1);

namespace SimonAnkele\LaravelQueryPipelines;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class BasePipe
{
    protected Request $request;

    /** Builder<\Illuminate\Database\Eloquent\Model> $query */
    protected Builder $query;

    public function __construct()
    {
        $this->request = app(Request::class);
    }

    abstract protected function apply(): static;

    abstract public function handle($query, Closure $next);

    protected function getDriverName(): string
    {
        $connection = $this->query->getConnection();

        return $connection->getDriverName();
    }
}
