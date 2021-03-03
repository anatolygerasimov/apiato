<?php

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

/**
 * Class ThisNotMatchListThat
 */
class ThisNotMatchListThat extends Criteria
{
    /**
     * @var string
     */
    private string $field;

    /**
     * @var array
     */
    private array $values;

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
        return $model->whereNotIn($this->field, $this->values);
    }
}
