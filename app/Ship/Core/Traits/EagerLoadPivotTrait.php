<?php

namespace App\Ship\Core\Traits;

use Illuminate\Database\Eloquent\Builder;

trait EagerLoadPivotTrait
{
    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new EagerLoadPivotBuilder($query);
    }
}
