<?php

/** @noinspection MultipleExpectChainableInspection */

declare(strict_types=1);

use SimonAnkele\LaravelQueryPipelines\BaseFilter;
use SimonAnkele\LaravelQueryPipelines\BasePipeline;
use SimonAnkele\LaravelQueryPipelines\Enums\WhereType;
use SimonAnkele\LaravelQueryPipelines\Enums\WildcardPosition;
use SimonAnkele\LaravelQueryPipelines\Filters\LikeFilter;
use SimonAnkele\LaravelQueryPipelines\Traits\Filterable;
use Tests\Models\TestModel;

mutates([LikeFilter::class, BaseFilter::class, BasePipeline::class, Filterable::class, WhereType::class, WildcardPosition::class]);
covers([LikeFilter::class, BaseFilter::class, Filterable::class, Filterable::class, WhereType::class, WildcardPosition::class]);

it('can filter by overriding request value with value method', function () {
    TestModel::factory()->create(['name' => 'TheFirstExample']);
    TestModel::factory()->create(['name' => 'TestSecondName']);
    TestModel::factory()->count(3)->create();

    injectRequest(['name' => 'First']);
    expect(TestModel::filter([
        LikeFilter::columns('name')->value('Second'),
    ])->count())->toBe(1);

    injectRequest(['name' => 'First']);
    expect(TestModel::filter([
        LikeFilter::columns('name')->value('Second'),
    ])->first()->name)->toBe('TestSecondName');
});

it('can filter by overriding request value with value method 2', function () {
    TestModel::factory()->create(['name' => 'TheFirstExample']);
    TestModel::factory()->create(['name' => 'TestSecondName']);
    TestModel::factory()->count(3)->create();

    injectRequest(['parameter' => 'First']);
        expect(TestModel::filter([
            LikeFilter::columns('name')->queryParameter('parameter')
        ])->count())->toBe(1);

        injectRequest(['parameter' => 'Second']);
        expect(TestModel::filter([
            LikeFilter::columns('name')->queryParameter('parameter')
        ])->first()->name)->toBe('TestSecondName');
});

it('can filter by using all method', function () {
    TestModel::factory()->create(['name' => 'TheFirstExample']);
    TestModel::factory()->create(['name' => 'TestSecondName']);
    TestModel::factory()->count(3)->create();

    injectRequest(['name' => 'First']);
    expect(TestModel::filter([
        LikeFilter::columns('name')->value('Second')->all(),
    ])->count())->toBe(1);

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('Second')->all(),
    ])->first()->name)->toBe('TestSecondName');
});

it('can filter by using left side wildcard', function () {
    TestModel::factory()->create(['name' => 'TheFirstExample']);
    TestModel::factory()->count(3)->create();

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('Example')->wildcard(WildcardPosition::LEFT),
    ])->count())->toBe(1);

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('TheFirst')->wildcard(WildcardPosition::LEFT),
    ])->count())->toBe(0);

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('TheFirstExample')->wildcard(WildcardPosition::LEFT),
    ])->count())->toBe(1);
});

it('can filter by using right side wildcard', function () {
    TestModel::factory()->create(['name' => 'TheFirstExample']);
    TestModel::factory()->count(3)->create();

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('Example')->wildcard(WildcardPosition::RIGHT),
    ])->count())->toBe(0);

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('TheFirst')->wildcard(WildcardPosition::RIGHT),
    ])->count())->toBe(1);

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('TheFirstExample')->wildcard(WildcardPosition::RIGHT),
    ])->count())->toBe(1);
});

it('can filter by using both side wildcard', function () {
    TestModel::factory()->create(['name' => 'TheFirstExample']);
    TestModel::factory()->count(3)->create();

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('TheFirst')->wildcard(WildcardPosition::BOTH),
    ])->count())->toBe(1);

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('TheFirstExample')->wildcard(WildcardPosition::BOTH),
    ])->count())->toBe(1);

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('FirstExample')->wildcard(WildcardPosition::BOTH),
    ])->count())->toBe(1);

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('TheVeryFirstExample')->wildcard(WildcardPosition::BOTH),
    ])->count())->toBe(0);
});

it('can filter by using two columns', function () {
    TestModel::factory()->create(['name' => 'TheFirstExample', 'description' => 'TheFirstDescription']);
    TestModel::factory()->create(['name' => 'TheSecondExample', 'description' => 'TheSecondDescription']);
    TestModel::factory()->count(3)->create();

    expect(TestModel::filter([
        LikeFilter::columns('name', 'description')->value('The'),
    ])->count())->toBe(2);
});

it('can filter by using two columns with all method', function () {
    TestModel::factory()->create(['name' => 'TheFirstExample', 'description' => 'FirstDescription']);
    TestModel::factory()->create(['name' => 'TheSecondExample', 'description' => 'TheSecondDescription']);
    TestModel::factory()->count(3)->create();

    expect(TestModel::filter([
        LikeFilter::columns('name', 'description')->value('The')->all(),
    ])->count())->toBe(1);

    expect(TestModel::filter([
        LikeFilter::columns('name', 'description')->value('Second')->all(),
    ])->count())->toBe(1);
});

it('can filter by using left side wildcard and all method', function () {
    TestModel::factory()->create(['name' => 'TheFirstExample', 'description' => 'TheFirstDescription']);
    TestModel::factory()->create(['name' => 'TheSecondExample', 'description' => 'TheSecondDescription']);
    TestModel::factory()->create(['name' => 'TheSecondExampleParameter', 'description' => 'TheSecondDescriptionParameter']);
    TestModel::factory()->count(3)->create();

    expect(TestModel::filter([
        LikeFilter::columns('name', 'description')->value('Parameter')->wildcard(WildcardPosition::LEFT)->all(),
    ])->count())->toBe(1);

    expect(TestModel::filter([
        LikeFilter::columns('name', 'description')->value('Example')->wildcard(WildcardPosition::LEFT)->all(),
    ])->count())->toBe(0);
});

it('can filter by using right side wildcard and all method', function () {
    TestModel::factory()->create(['name' => 'TheFirstExample', 'description' => 'TheFirstDescription']);
    TestModel::factory()->create(['name' => 'TheSecondExample', 'description' => 'TheSecondDescription']);
    TestModel::factory()->create(['name' => 'TheSecondExampleParameter', 'description' => 'TheSecondDescriptionParameter']);
    TestModel::factory()->count(3)->create();

    expect(TestModel::filter([
        LikeFilter::columns('name', 'description')->value('The')->wildcard(WildcardPosition::RIGHT)->all(),
    ])->count())->toBe(3);

    expect(TestModel::filter([
        LikeFilter::columns('name', 'description')->value('TheSecond')->wildcard(WildcardPosition::RIGHT)->all(),
    ])->count())->toBe(2);

    expect(TestModel::filter([
        LikeFilter::columns('name', 'description')->value('TheSecondExample')->wildcard(WildcardPosition::RIGHT)->all(),
    ])->count())->toBe(0);
});
