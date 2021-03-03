<?php

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

/**
 * Class OrderByFieldCriteria
 */
class OrderByFieldCriteria extends Criteria
{
    private $field;

    private $sortOrder;

    /**
     * OrderByFieldCriteria constructor.
     *
     * @param string $field     The field to be sorted
     * @param string $sortOrder the sort direction (asc or desc)
     */
    public function __construct(string $field, string $sortOrder)
    {
        $this->field = $field;

        $sortOrder           = Str::lower($sortOrder);
        $availableDirections = [
            'asc',
            'desc',
        ];

        // check if the value is available, otherwise set "default" sort order to ascending!
        if (!array_search($sortOrder, $availableDirections)) {
            $sortOrder = 'asc';
        }

        $this->sortOrder = $sortOrder;
    }

    /**
     * @param Builder|Model              $model
     * @param PrettusRepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->orderBy($this->field, $this->sortOrder);
    }
}
