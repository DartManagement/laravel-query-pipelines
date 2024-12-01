<?php

declare(strict_types=1);

namespace Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\Models\TestModel;

class TestModelFactory extends Factory
{
    protected $model = TestModel::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(100),
            'type_flag' => $this->faker->randomElement([1, 2, 4]),
            'is_visible' => $this->faker->boolean,
            'created_at' => $this->faker->dateTime,
        ];
    }
}
