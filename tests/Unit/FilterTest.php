<?php /** @noinspection MultipleExpectChainableInspection */

declare(strict_types=1);

use SimonAnkele\LaravelQueryPipelines\BaseFilter;
use SimonAnkele\LaravelQueryPipelines\BasePipeline;
use SimonAnkele\LaravelQueryPipelines\Enums\WildcardPosition;
use SimonAnkele\LaravelQueryPipelines\Filters\LikeFilter;
use Tests\Models\TestModel;

mutates([LikeFilter::class, BaseFilter::class, BasePipeline::class]);

it('can filter by overriding request value with value method', function () {
    TestModel::factory()->create(['name' => 'TheFirstExample']);
    TestModel::factory()->create(['name' => 'TestSecondName']);
    TestModel::factory()->count(3)->create();

    injectRequest(['name' => 'First']);
    expect(TestModel::filter([
        LikeFilter::columns('name')->value('Second')
    ])->count())->toBe(1);

    injectRequest(['name' => 'First']);
    expect(TestModel::filter([
        LikeFilter::columns('name')->value('Second')
    ])->first()->name)->toBe('TestSecondName');
});

it('can filter by using all method', function () {
    TestModel::factory()->create(['name' => 'TheFirstExample']);
    TestModel::factory()->create(['name' => 'TestSecondName']);
    TestModel::factory()->count(3)->create();

    injectRequest(['name' => 'First']);

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('Second')->all()
    ])->count())->toBe(1);

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('Second')->all()
    ])->first()->name)->toBe('TestSecondName');
});

it('can filter by using left side wildcard', function () {
    TestModel::factory()->create(['name' => 'TheFirstExample']);
    TestModel::factory()->count(3)->create();

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('Example')->wildcard(WildcardPosition::LEFT)
    ])->count())->toBe(1);

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('TheFirst')->wildcard(WildcardPosition::LEFT)
    ])->count())->toBe(0);

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('TheFirstExample')->wildcard(WildcardPosition::LEFT)
    ])->count())->toBe(1);
});

it('can filter by using right side wildcard', function () {
    TestModel::factory()->create(['name' => 'TheFirstExample']);
    TestModel::factory()->count(3)->create();

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('Example')->wildcard(WildcardPosition::RIGHT)
    ])->count())->toBe(0);

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('TheFirst')->wildcard(WildcardPosition::RIGHT)
    ])->count())->toBe(1);

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('TheFirstExample')->wildcard(WildcardPosition::RIGHT)
    ])->count())->toBe(1);
});

it('can filter by using both side wildcard', function () {
    TestModel::factory()->create(['name' => 'TheFirstExample']);
    TestModel::factory()->count(3)->create();

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('TheFirst')->wildcard(WildcardPosition::BOTH)
    ])->count())->toBe(1);

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('TheFirstExample')->wildcard(WildcardPosition::BOTH)
    ])->count())->toBe(1);

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('FirstExample')->wildcard(WildcardPosition::BOTH)
    ])->count())->toBe(1);

    expect(TestModel::filter([
        LikeFilter::columns('name')->value('TheVeryFirstExample')->wildcard(WildcardPosition::BOTH)
    ])->count())->toBe(0);
});

it('can filter by using two columns', function () {
    TestModel::factory()->create(['name' => 'TheFirstExample', 'description' => 'TheFirstDescription']);
    TestModel::factory()->create(['name' => 'TheSecondExample', 'description' => 'TheSecondDescription']);
    TestModel::factory()->count(3)->create();

    expect(TestModel::filter([
        LikeFilter::columns('name', 'description')->value('The')
    ])->count())->toBe(2);
});

it('can filter by using two columns with all method', function () {
    TestModel::factory()->create(['name' => 'TheFirstExample', 'description' => 'FirstDescription']);
    TestModel::factory()->create(['name' => 'TheSecondExample', 'description' => 'TheSecondDescription']);
    TestModel::factory()->count(3)->create();

    expect(TestModel::filter([
        LikeFilter::columns('name', 'description')->value('The')->all()
    ])->count())->toBe(1);

    expect(TestModel::filter([
        LikeFilter::columns('name', 'description')->value('Second')->all()
    ])->count())->toBe(1);
});


it('can filter by using left side wildcard and all method', function () {
    TestModel::factory()->create(['name' => 'TheFirstExample', 'description' => 'TheFirstDescription']);
    TestModel::factory()->create(['name' => 'TheSecondExample', 'description' => 'TheSecondDescription']);
    TestModel::factory()->create(['name' => 'TheSecondExampleParameter', 'description' => 'TheSecondDescriptionParameter']);
    TestModel::factory()->count(3)->create();

    expect(TestModel::filter([
        LikeFilter::columns('name', 'description')->value('Parameter')->wildcard(WildcardPosition::LEFT)->all()
    ])->count())->toBe(1);

    expect(TestModel::filter([
        LikeFilter::columns('name', 'description')->value('Example')->wildcard(WildcardPosition::LEFT)->all()
    ])->count())->toBe(0);
});

it('can filter by using right side wildcard and all method', function () {
    TestModel::factory()->create(['name' => 'TheFirstExample', 'description' => 'TheFirstDescription']);
    TestModel::factory()->create(['name' => 'TheSecondExample', 'description' => 'TheSecondDescription']);
    TestModel::factory()->create(['name' => 'TheSecondExampleParameter', 'description' => 'TheSecondDescriptionParameter']);
    TestModel::factory()->count(3)->create();

    expect(TestModel::filter([
        LikeFilter::columns('name', 'description')->value('The')->wildcard(WildcardPosition::RIGHT)->all()
    ])->count())->toBe(3);

    expect(TestModel::filter([
        LikeFilter::columns('name', 'description')->value('TheSecond')->wildcard(WildcardPosition::RIGHT)->all()
    ])->count())->toBe(2);

    expect(TestModel::filter([
        LikeFilter::columns('name', 'description')->value('TheSecondExample')->wildcard(WildcardPosition::RIGHT)->all()
    ])->count())->toBe(0);
});

//
//it('can filter by using right side wildcard and all method', function () {
//    TestModel::factory()->create(['name' => 'TheFirstExample']);
//    TestModel::factory()->count(3)->create();
//
//    expect(TestModel::filter([
//        LikeFilter::columns('name')->value('Example')->wildcard(WildcardPosition::RIGHT)->all()
//    ])->count())->toBe(0);
//
//    expect(TestModel::filter([
//        LikeFilter::columns('name')->value('TheFirst')->wildcard(WildcardPosition::RIGHT)->all()
//    ])->count())->toBe(1);
//
//    expect(TestModel::filter([
//        LikeFilter::columns('name')->value('TheFirstExample')->wildcard(WildcardPosition::RIGHT)->all()
//    ])->count())->toBe(1);
//});
//
//it('can filter by using both side wildcard and all method', function () {
//    TestModel::factory()->create(['name' => 'TheFirstExample']);
//    TestModel::factory()->count(3)->create();
//
//    expect(TestModel::filter([
//        LikeFilter::columns('name')->value('TheFirst')->wildcard(WildcardPosition::BOTH)->all()
//    ])->count())->toBe(1);
//
//    expect(TestModel::filter([
//        LikeFilter::columns('name')->value('TheFirstExample')->wildcard(WildcardPosition::BOTH)->all()
//    ])->count())->toBe(1);
//
//    expect(TestModel::filter([
//        LikeFilter::columns('name')->value('FirstExample')->wildcard(WildcardPosition::BOTH)->all()
//    ])->count())->toBe(1);
//
//    expect(TestModel::filter([
//        LikeFilter::columns('name')->value('TheVeryFirstExample')->wildcard(WildcardPosition::BOTH)->all()
//    ])->count())->toBe(0);
//});
//
//it('can filter models by boolean value', function () {
//    TestModel::factory()->count(3)->create(['is_visible' => true]);
//    TestModel::factory()->count(4)->create(['is_visible' => false]);
//
//    injectRequest(['is_visible' => true]);
//    expect(TestModel::filter()->count())->toBe(3);
//
//    injectRequest(['is_visible' => false]);
//    expect(TestModel::filter()->count())->toBe(4);
//});
//
//it('can filter models by date from value', function () {
//    TestModel::factory()->count(3)->create(['created_at' => '2020-01-01']);
//    TestModel::factory()->count(4)->create(['created_at' => '2020-01-02']);
//
////    injectRequest(['created_at_from' => '2020-01-03']);
////    expect(TestModel::filter()->count())->toBe(7);
////
////    injectRequest(['created_at_from' => '2020-01-02']);
////
////    expect(TestModel::filter([
////        DateFromFilter::make('created_at', Motion::TILL), // where created_at > 2020-01-02
////    ])->count())->toBe(0);
//
//    //?created_at_from=2020-01-02
////    expect(TestModel::filter()->count())->toBe(7)
////        ->and(TestModel::filter([
////            DateFromFilter::make('created_at', Motion::TILL), // where created_at < 2020-01-02
////        ])->count())->toBe(0);
//
////    injectRequest(['created_at_from' => '2020-01-01']);
////    expect(TestModel::filter()->count())->toBe(7)
////        ->and(TestModel::filter([
////            DateFromFilter::make('created_at', Motion::TILL),
////        ])->count())->toBe(4);
////
////    injectRequest(['created_at_start' => '2020-01-01']);
////    expect(TestModel::filter()->count())->toBe(7)
////        ->and(TestModel::filter([
////            DateFromFilter::make('created_at', Motion::TILL)->setPostFix('start'),
////        ])->count())->toBe(4);
//});
//
//it('can filter models by date to value', function () {
//    $testModel1 = TestModel::factory()->count(4)->create(['created_at' => today()->addDays(4)]);
//    $testModel2 = TestModel::factory()->count(7)->create(['created_at' => today()->addDays(7)]);
//
//
////    injectRequest(['created_at_to' => today()->addDays(4)->toDateString()]);
////    expect(TestModel::filter()->count())->toBe(4);
////    expect(TestModel::filter([
////        DateToFilter::make('created_at', MotionEnum::TILL),
////    ])->count())->toBe(0);
//
////    injectRequest(['created_at_end' => today()->addDays(4)->toDateString()]);
////    expect(TestModel::filter()->count())->toBe(4);
////    expect(TestModel::filter([
////        DateToFilter::make('created_at', MotionEnum::TILL)->setPostFix('end'),
////    ])->count())->toBe(0);
//
////    injectRequest(['created_at_to' => today()->addDays(7)]);
////    expect(TestModel::filter()->count())->toBe(11);
////    expect(TestModel::filter([
////        DateToFilter::make('created_at', MotionEnum::TILL),
////    ])->count())->toBe(4);
//    $injection = today()->subDays(7)->toDateString();
//    //dd($testModel1->toArray(), $testModel2->toArray(), $injection);
//    injectRequest(['created_at_to' => today()->subDays(7)->toDateString()]);
//    expect(TestModel::count())->toBe(11);
//});
//
//it('can filter models by exact value', function () {
//    $now = now();
//    TestModel::factory()->count(3)->create(['updated_at' => $now]);
//    TestModel::factory()->count(4)->create(['updated_at' => $now->subSeconds(5)]);
//
//    injectRequest(['updated_at' => $now]);
//    expect(TestModel::filter()->count())->toBe(4);
//});
//
//it('can filter models by relationship belongsTo value', function () {
//    $related1 = RelatedModel::factory()->create();
//    $related2 = RelatedModel::factory()->create();
//    $related3 = RelatedModel::factory()->create();
//    TestModel::factory()->count(3)->create([
//        'related_model_id' => $related1->id,
//    ]);
//    $models = TestModel::factory()->count(4)->create([
//        'related_model_id' => $related2->id,
//    ]);
//    $models->each(function (TestModel $model) use ($related3) {
//        $model->belongsToManyRelatedModels()->attach($related3->id);
//    });
//
//    injectRequest(['belongs_to_many_related_models_id' => $related3->id]);
//    expect(TestModel::filter()->count())->toBe(4);
//});
//
//it('can filter models by relationship belongsToMany value', function () {
//    $related3 = RelatedModel::factory()->create();
//    $models = TestModel::factory()->count(4)->create();
//    $models->each(function (TestModel $model) use ($related3) {
//        $model->belongsToManyRelatedModels()->attach($related3->id);
//    });
//
//    injectRequest(['belongs_to_many_related_models_id' => $related3->id]);
//    expect(TestModel::filter()->count())->toBe(4);
//});
//it('can filter models by relative value', function () {
//    TestModel::factory()->create(['name' => 'Baro Nil']);
//
//    injectRequest(['name' => 'aro']);
//    expect(TestModel::filter()->count())->toBe(1);
//
//    injectRequest(['name' => 'aro']);
//    expect(TestModel::filter([
//        RelativeFilter::make('name', WildcardPosition::RIGHT),
//    ])->count())->toBe(0);
//
//    injectRequest(['name' => 'Baro']);
//    expect(TestModel::filter([
//        RelativeFilter::make('name', WildcardPosition::RIGHT),
//    ])->count())->toBe(1);
//
//    injectRequest(['name' => 'ni']);
//    expect(TestModel::filter([
//        RelativeFilter::make('name', WildcardPosition::LEFT),
//    ])->count())->toBe(0);
//
//    injectRequest(['name' => 'nil']);
//    expect(TestModel::filter([
//        RelativeFilter::make('name', WildcardPosition::LEFT),
//    ])->count())->toBe(1);
//});
//
//it('can filter models with local scope', function () {
//    TestModel::factory()->create(['name' => 'Baro Nil']);
//    TestModel::factory()->create(['name' => 'Billy Joe']);
//
//    injectRequest(['search' => 'Baro']);
//    expect(TestModel::filter()->count())->toBe(1);
//
//    injectRequest(['search' => '1']);
//    expect(TestModel::filter()->count())->toBe(1);
//
//    injectRequest(['search' => 'Tom']);
//    expect(TestModel::filter()->count())->toBe(0);
//});
//
//it('can filter models with prefix detect key', function () {
//    TestModel::factory()->create(['name' => 'Baro Nil']);
//    TestModel::factory()->create(['name' => 'Billy Joe']);
//
//    injectRequest(['filter' => ['name' => 'Baro']]);
//    expect(TestModel::filter([
//        RelativeFilter::make('name')->detectBy('filter.'),
//    ])->count())->toBe(1);
//});
//
//it('can filter models with custom column search', function () {
//    TestModel::factory()->create(['name' => 'Baro Nil']);
//    TestModel::factory()->create(['name' => 'Billy Joe']);
//
//    injectRequest(['title' => 'Baro']);
//    expect(TestModel::filter([
//        RelativeFilter::make('title')->filterOn('name'),
//    ])->count())->toBe(1);
//});
//
//it('can filter model with trashed', function () {
//    TestModel::factory()->count(10)->create();
//    TestModel::query()->limit(4)->delete();
//
//    expect(TestModel::filter()->count())->toBe(6);
//
//    injectRequest(['trashed' => 'with']);
//    expect(TestModel::filter()->count())->toBe(10);
//
//    injectRequest(['trashed' => 'only']);
//    expect(TestModel::filter()->count())->toBe(4);
//});
//
//it('can filter model using fixed value', function () {
//    TestModel::factory()->create(['name' => 'Baro Nil']);
//    TestModel::factory()->create(['name' => 'Billy Joe']);
//
//    injectRequest(['title' => 'John']);
//    expect(TestModel::filter([
//        RelativeFilter::make('title')->filterOn('name'),
//    ])->count())->toBe(0)
//        ->and(TestModel::filter([
//            RelativeFilter::make('title')->filterOn('name')->value('Baro'),
//        ])->count())->toBe(1);
//});
