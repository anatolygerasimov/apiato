<?php

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

/**
 * Class ThisEqualThatCriteria
 */
class ThisEqualThatCriteria extends Criteria
{
    private string $field;

    /**
     * @var mixed
     */
    private $value;

    /**
     * ThisEqualThatCriteria constructor.
     *
     * @param string $field
     * @param mixed  $value
     */
    public function __construct(string $field, $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    /**
     * @param Builder|Model              $model
     * @param PrettusRepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where($this->field, '=', $this->value);
    }
}
