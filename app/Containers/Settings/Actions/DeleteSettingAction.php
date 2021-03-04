<?php

declare(strict_types=1);

namespace App\Containers\Settings\Actions;

use App\Containers\Settings\UI\API\Requests\DeleteSettingRequest;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class DeleteSettingAction.
 */
class DeleteSettingAction extends Action
{
    public function run(DeleteSettingRequest $request): void
    {
        $setting = Apiato::call('Settings@FindSettingByIdTask', [$request->id]);

      Apiato::call('Settings@DeleteSettingTask', [$setting]);
    }
}
