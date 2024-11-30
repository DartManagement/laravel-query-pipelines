<?php

declare(strict_types=1);

namespace Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\Models\RelatedModel;

class RelatedModelFactory extends Factory
{
    protected $model = RelatedModel::class;

    public function definition(): array
    {
        return [];
    }
}
