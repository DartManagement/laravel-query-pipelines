<?php

declare(strict_types=1);

namespace SimonAnkele\LaravelQueryPipelines;

use Illuminate\Support\ServiceProvider;

final class LaravelQueryPipelinesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
//        $this->publishes([
//            __DIR__.'/../config/query-pipelines.php' => config_path('query-pipelines.php'),
//        ]);
    }
}
