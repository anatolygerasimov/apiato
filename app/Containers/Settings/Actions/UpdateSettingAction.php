<?php

declare(strict_types=1);

namespace App\Containers\Settings\Actions;

use App\Containers\Settings\Models\Setting;
use App\Containers\Settings\UI\API\Requests\UpdateSettingRequest;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class UpdateSettingAction.
 */
class UpdateSettingAction extends Action
{
    public function run(UpdateSettingRequest $request): Setting
    {
        $sanitizedData = $request->sanitizeInput([
            'key',
            'value',
        ]);

        return Apiato::call('Settings@UpdateSettingTask', [$request->id, $sanitizedData]);
    }
}
