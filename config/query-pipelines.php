<?php

declare(strict_types=1);

use DartManagement\LaravelQueryPipelines\Enums\WildcardPosition;

return [
    // key to detect param to filter
    'detect_key' => env('PIPELINE_QUERY_COLLECTION_DETECT_KEY', ''),

    // Allow the default wildcard position for relative filters to be controlled via .env.
    'relative_wildcard_position' => WildcardPosition::tryFrom(
        env('PIPELINE_QUERY_COLLECTION_WILDCARD_POSITION', 'both')
    ),

    // type of postfix for date filters
    'date_from_postfix' => env('PIPELINE_QUERY_COLLECTION_DATE_FROM_POSTFIX', 'from'),
    'date_to_postfix' => env('PIPELINE_QUERY_COLLECTION_DATE_TO_POSTFIX', 'to'),

    // default motion for date filters, can be 'find' or 'till'
    'date_motion' => env('PIPELINE_QUERY_COLLECTION_DATE_MOTION', 'find'),
];
