<?php

declare(strict_types=1);

namespace App\Containers\Settings\Tasks;

use App\Containers\Settings\Data\Criterias\OrderByKeyAscendingCriteria;
use App\Containers\Settings\Data\Repositories\SettingRepository;
use App\Containers\Settings\Models\Setting;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllSettingsTask extends Task
{
    protected SettingRepository $repository;

    /**
     * GetAllSettingsTask constructor.
     */
    public function __construct(SettingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Setting[]|Collection
     */
    public function run()
    {
        return $this->repository->paginate();
    }

    /**
     * @throws RepositoryException
     */
    public function ordered(): SettingRepository
    {
        return $this->repository->pushCriteria(new OrderByKeyAscendingCriteria());
    }
}
