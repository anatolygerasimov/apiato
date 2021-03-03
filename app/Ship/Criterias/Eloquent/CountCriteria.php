<?php

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

/**
 * Class CountCriteria
 */
class CountCriteria extends Criteria
{
    private string $field;

    public function __construct(string $field)
    {
        $this->field = $field;
    }

    /**
     * @param Builder|Model              $model
     * @param PrettusRepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return DB::table($model->getModel()->getTable())->select($this->field, DB::raw('count(' . $this->field . ') as total_count'))->groupBy($this->field);
    }
}
