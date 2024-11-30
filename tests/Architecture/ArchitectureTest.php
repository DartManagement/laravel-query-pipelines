<?php

declare(strict_types=1);

arch()->preset()->laravel();

arch()
    ->expect('App')
    ->toUseStrictTypes()
    ->not->toUse(['die', 'dd', 'dump']);

arch()
    ->expect('SimonAnkele\LaravelQueryPipelines')
    ->toUseStrictTypes()
    ->not->toUse(['die', 'dd', 'dump']);
