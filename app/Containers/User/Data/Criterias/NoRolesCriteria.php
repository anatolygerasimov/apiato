<?php

declare(strict_types=1);

namespace App\Containers\User\Data\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

/**
 * Class NoRoleCriteria.
 */
class NoRolesCriteria extends Criteria
{
    /**
     * @param Builder|Model $model
     *
     * @return Builder|Model
     *
     * @psalm-return Builder<Model>|Model
     */
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->doesntHave('roles');
    }
}
