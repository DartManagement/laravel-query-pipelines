<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Orchestra\Testbench\TestCase as Orchestra;
use DartManagement\LaravelQueryPipelines\LaravelQueryPipelinesServiceProvider;

abstract class TestCase extends Orchestra
{
    use DatabaseMigrations;

    protected function getPackageProviders($app): array
    {
        return [LaravelQueryPipelinesServiceProvider::class];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'DartManagement\\LaravelQueryPipelines\\Tests\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function setUpDatabase(Application $app): void
    {
        $app['db']->connection()->getSchemaBuilder()->create('test_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->unsignedTinyInteger('type_flag')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->unsignedInteger('related_model_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        $app['db']->connection()->getSchemaBuilder()->create('related_models', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        $app['db']->connection()->getSchemaBuilder()->create('pivot_table', function (Blueprint $table) {
            $table->unsignedInteger('test_model_id');
            $table->unsignedInteger('related_model_id');
        });
    }
}
