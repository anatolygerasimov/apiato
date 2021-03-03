<?php

namespace App\Ship\Parents\Repositories;

use App\Ship\Core\Abstracts\Repositories\Repository as AbstractRepository;

/**
 * Class Repository.
 */
abstract class Repository extends AbstractRepository
{
    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        parent::boot();
    }
}
