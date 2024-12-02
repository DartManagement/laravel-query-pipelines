<?php

declare(strict_types=1);

namespace Tests\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DartManagement\LaravelQueryPipelines\Traits\Filterable;
use Tests\Factories\TestModelFactory;

class TestModel extends Model
{
    use Filterable;
    use HasFactory;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): TestModelFactory|Factory
    {
        return TestModelFactory::new();
    }
}
