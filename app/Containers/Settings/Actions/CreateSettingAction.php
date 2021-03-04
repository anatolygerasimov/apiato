<?php

declare(strict_types=1);

namespace App\Containers\Settings\Actions;

use App\Containers\Settings\Models\Setting;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Transporters\DataTransporter;

/**
 * Class CreateSettingAction.
 */
class CreateSettingAction extends Action
{
    public function run(DataTransporter $data): Setting
    {
        $data = $data->sanitizeInput([
            'key',
            'value',
        ]);

        return Apiato::call('Settings@CreateSettingTask', [$data]);
    }
}
