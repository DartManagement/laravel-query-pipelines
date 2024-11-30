<?php

declare(strict_types=1);

namespace Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PivotModel extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function testModels(): BelongsToMany
    {
        return $this->belongsToMany(TestModel::class, 'pivot_table', 'pivot_model_id', 'test_model_id');
    }
}
