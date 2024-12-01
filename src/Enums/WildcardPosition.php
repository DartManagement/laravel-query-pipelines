<?php

declare(strict_types=1);

namespace App\Enums\QueryPipeline;

enum WildcardPosition: string
{
    case BOTH = 'both';
    case LEFT = 'left';
    case RIGHT = 'right';
}
