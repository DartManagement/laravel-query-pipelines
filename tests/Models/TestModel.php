<?php

declare(strict_types=1);

namespace Tests\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use SimonAnkele\LaravelQueryPipelines\Concerns\HasFilterableQueryPipeline;
use SimonAnkele\LaravelQueryPipelines\Concerns\HasSortableQueryPipeline;
use SimonAnkele\LaravelQueryPipelines\Filters\BitwiseFilter;
use SimonAnkele\LaravelQueryPipelines\Filters\BooleanFilter;
use SimonAnkele\LaravelQueryPipelines\Filters\DateFromFilter;
use SimonAnkele\LaravelQueryPipelines\Filters\DateToFilter;
use SimonAnkele\LaravelQueryPipelines\Filters\ExactFilter;
use SimonAnkele\LaravelQueryPipelines\Filters\RelationFilter;
use SimonAnkele\LaravelQueryPipelines\Filters\RelativeFilter;
use SimonAnkele\LaravelQueryPipelines\Filters\ScopeFilter;
use SimonAnkele\LaravelQueryPipelines\Filters\TrashFilter;
use SimonAnkele\LaravelQueryPipelines\Sortings\Sort;
use Tests\Factories\TestModelFactory;

class TestModel extends Model
{
    use HasFactory;
    use HasFilterableQueryPipeline;
    use HasSortableQueryPipeline;
    use SoftDeletes;

    protected $guarded = [];

    protected function getFilters(): array
    {
        return [
            BitwiseFilter::make('type_flag'),
            BooleanFilter::make('is_visible'),
            DateFromFilter::make('created_at'),
            DateToFilter::make('created_at'),
            ExactFilter::make('updated_at'),
            RelationFilter::make('belongs_to_related_models', 'id'),
            RelationFilter::make('belongs_to_many_related_models', 'id'),
            RelativeFilter::make('name'),
            ScopeFilter::make('search'),
            TrashFilter::make(),
        ];
    }

    protected function getSorts(): array
    {
        return [
            Sort::make(),
        ];
    }

    public function belongsToRelatedModels(): BelongsTo
    {
        return $this->belongsTo(RelatedModel::class, 'related_model_id');
    }

    public function belongsToManyRelatedModels(): BelongsToMany
    {
        return $this->belongsToMany(RelatedModel::class, 'pivot_table');
    }

    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(
            fn (Builder $query) => $query
                ->where('name', 'like', "%{$search}%")
                ->orWhere('id', $search)
        );
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): TestModelFactory|Factory
    {
        return TestModelFactory::new();
    }
}
