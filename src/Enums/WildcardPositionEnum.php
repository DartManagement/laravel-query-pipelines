<?php

declare(strict_types=1);

namespace SimonAnkele\LaravelQueryPipelines\Enums;

enum WildcardPositionEnum: string
{
    case BOTH = 'both';
    case LEFT = 'left';
    case RIGHT = 'right';
}
