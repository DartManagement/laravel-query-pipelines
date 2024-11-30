<?php

declare(strict_types=1);

use Tests\Models\TestModel;

test('example', function () {
    TestModel::factory()->create(['type_flag' => 1]);
    expect(true)->toBeTrue();
});
