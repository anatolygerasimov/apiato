<?php

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

/**
 * Class OrderBySeveralFieldsCriteria
 */
class OrderBySeveralFieldsCriteria extends Criteria
{
    private string $field;

    private array $values;

    /**
     * OrderByFieldCriteria constructor.
     *
     * @param string $field     The field to be sorted
     * @param array  $values    Sorting a field by values
     */
    public function __construct(string $field, array $values)
    {
        $this->field  = $field;
        $this->values = $values;
    }

    /**
     * @param Builder|Model              $model
     * @param PrettusRepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        $placeholders = implode(', ', array_fill(0, count($this->values), '?'));
        return $model->orderByRaw("FIELD({$this->field}, {$placeholders})", $placeholders);
    }
}
