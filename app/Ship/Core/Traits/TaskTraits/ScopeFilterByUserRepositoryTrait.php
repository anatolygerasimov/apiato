<?php

declare(strict_types=1);

namespace App\Ship\Core\Traits\TaskTraits;

use App\Ship\Criterias\Eloquent\ThisUserCriteria;
use App\Ship\Parents\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait ScopeFilterByUserRepositoryTrait.
 *
 * @property Repository $repository
 */
trait ScopeFilterByUserRepositoryTrait
{
    /**
     * @param int|null $userId
     *
     * @return Repository
     */
    public function filterByUser(?int $userId = null): Repository
    {
        return $this->repository->scopeQuery(
            /** @param Model|Builder $model */
            fn ($model): Builder => (new ThisUserCriteria($userId))->apply($model, $this->repository)
        );
    }
}
