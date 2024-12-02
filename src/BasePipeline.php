<?php

declare(strict_types=1);

namespace SimonAnkele\LaravelQueryPipelines;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class BasePipeline
{
    /**
     * @var Builder<Model>
     */
    protected Builder $query;

    protected ?Request $request = null;

    public function __construct()
    {
        $this->request = app(Request::class);
    }

    abstract protected function apply(): static;

    /**
     * @param  Builder<Model>  $query
     * @return Builder<Model>
     */
    abstract public function handle(Builder $query, Closure $next): Builder;
}
