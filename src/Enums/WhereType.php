<?php

declare(strict_types=1);

namespace SimonAnkele\LaravelQueryPipelines\Enums;

enum WhereType: string
{
    case ALL = 'all';
    case ANY = 'any';
}
