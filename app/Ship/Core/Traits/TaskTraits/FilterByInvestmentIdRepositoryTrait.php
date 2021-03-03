<?php

declare(strict_types=1);

namespace App\Ship\Core\Traits\TaskTraits;

use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Parents\Repositories\Repository;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Trait FilterByInvestmentIdRepositoryTrait.
 *
 * @property Repository $repository
 */
trait FilterByInvestmentIdRepositoryTrait
{
    /**
     * @param int $investmentId
     *
     * @return Repository
     *
     * @throws RepositoryException
     */
    public function filterByInvestmentId(int $investmentId): Repository
    {
        return $this->repository->pushCriteria(new ThisEqualThatCriteria('investment_id', $investmentId));
    }
}
