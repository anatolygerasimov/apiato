<?php

declare(strict_types=1);

namespace App\Containers\Settings\Tasks;

use App\Containers\Settings\Data\Repositories\SettingRepository;
use App\Containers\Settings\Models\Setting;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteSettingTask extends Task
{
    protected SettingRepository $repository;

    public function __construct(SettingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws DeleteResourceFailedException
     */
    public function run(Setting $setting): bool
    {
        try {
            return (bool)$this->repository->delete($setting->id);
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException();
        }
    }
}
