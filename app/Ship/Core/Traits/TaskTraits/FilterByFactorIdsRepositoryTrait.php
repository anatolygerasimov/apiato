<?php

declare(strict_types=1);

namespace App\Ship\Core\Traits\TaskTraits;

use App\Ship\Criterias\Eloquent\ThisMatchListThat;
use App\Ship\Parents\Repositories\Repository;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Trait FilterByFactorIdsRepositoryTrait.
 *
 * @property Repository $repository
 */
trait FilterByFactorIdsRepositoryTrait
{
    /**
     * @param array $factorIds
     *
     * @return Repository
     *
     * @throws RepositoryException
     */
    public function filterByFactorIds(array $factorIds): Repository
    {
        return $this->repository->pushCriteria(new ThisMatchListThat('factor_id', $factorIds));
    }
}
