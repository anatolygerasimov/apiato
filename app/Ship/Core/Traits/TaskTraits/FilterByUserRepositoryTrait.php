<?php

declare(strict_types=1);

namespace App\Ship\Core\Traits\TaskTraits;

use App\Ship\Criterias\Eloquent\ThisUserCriteria;
use App\Ship\Parents\Repositories\Repository;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Trait FilterByUserRepositoryTrait.
 *
 * @property Repository $repository
 */
trait FilterByUserRepositoryTrait
{
    /**
     * @param int|null $userId
     *
     * @return Repository
     *
     * @throws RepositoryException
     */
    public function filterByUser(?int $userId = null): Repository
    {
        return $this->repository->pushCriteria(new ThisUserCriteria($userId));
    }
}
