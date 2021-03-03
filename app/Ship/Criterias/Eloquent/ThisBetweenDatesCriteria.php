<?php

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

/**
 * Class ThisBetweenDatesCriteria
 *
 * Retrieves all entities whose date $field's value is between $start and $end.
 */
class ThisBetweenDatesCriteria extends Criteria
{
    private Carbon $start;

    private Carbon $end;

    private string $field;


    public function __construct(string $field, Carbon $start, Carbon $end)
    {
        $this->start = $start;
        $this->end   = $end;
        $this->field = $field;
    }

    /**
     * Applies the criteria.
     *
     * @param Builder|Model              $model
     * @param PrettusRepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->whereBetween($this->field, [$this->start->toDateString(), $this->end->toDateString()]);
    }
}
