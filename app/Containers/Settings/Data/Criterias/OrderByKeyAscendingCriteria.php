<?php

declare(strict_types=1);

namespace App\Containers\Settings\Data\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

/**
 * Class OrderByKeyAscendingCriteria.
 */
class OrderByKeyAscendingCriteria extends Criteria
{
    /**
     * @param Builder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->orderBy('key', 'asc');
    }
}
