<?php

declare(strict_types=1);

namespace App\Containers\Settings\Tasks;

use App\Containers\Settings\Data\Repositories\SettingRepository;
use App\Containers\Settings\Models\Setting;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

/**
 * Class UpdateSettingsByKeyTask.
 */
class UpdateSettingsByKeyTask extends Task
{
    protected SettingRepository $repository;

    public function __construct(SettingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(string $key, string $value): Setting
    {
        $setting = $this->repository->findWhere(['key' => $key])->first();

        if (!$setting) {
            throw new NotFoundException();
        }

        try {
            return $this->repository->update([
                'value' => $value,
            ], $setting->id);
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
