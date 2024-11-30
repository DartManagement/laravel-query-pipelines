<?php

declare(strict_types=1);

namespace SimonAnkele\LaravelQueryPipelines\Facades;

use Illuminate\Support\Facades\Facade;

final class LaravelQueryPipelines extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return LaravelQueryPipelines::class;
    }
}
