<?php

declare(strict_types=1);

namespace DartManagement\LaravelQueryPipelines\Enums;

enum WhereType: string
{
    case ALL = 'all';
    case ANY = 'any';
}
