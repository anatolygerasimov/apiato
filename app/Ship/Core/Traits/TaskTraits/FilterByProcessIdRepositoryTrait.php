<?php

declare(strict_types=1);

namespace App\Ship\Core\Traits\TaskTraits;

use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Parents\Repositories\Repository;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Trait FilterByProcessIdRepositoryTrait.
 *
 * @property Repository $repository
 */
trait FilterByProcessIdRepositoryTrait
{
    /**
     * @param int $processId
     *
     * @return Repository
     *
     * @throws RepositoryException
     */
    public function filterByProcessId(int $processId): Repository
    {
        return $this->repository->pushCriteria(new ThisEqualThatCriteria('process_id', $processId));
    }
}
