<?php

declare(strict_types=1);

namespace App\Containers\Settings\UI\API\Controllers;

use App\Containers\Settings\UI\API\Requests\CreateSettingRequest;
use App\Containers\Settings\UI\API\Requests\DeleteSettingRequest;
use App\Containers\Settings\UI\API\Requests\GetAllSettingsRequest;
use App\Containers\Settings\UI\API\Requests\UpdateSettingRequest;
use App\Containers\Settings\UI\API\Transformers\SettingTransformer;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Controllers\ApiController;
use App\Ship\Transporters\DataTransporter;
use Illuminate\Http\JsonResponse;

/**
 * Class Controller.
 */
class Controller extends ApiController
{
    /**
     * Get All application settings.
     *
     * @return array
     */
    public function getAllSettings(GetAllSettingsRequest $request)
    {
        $settings = Apiato::call('Settings@GetAllSettingsAction');

        return $this->transform($settings, SettingTransformer::class);
    }

    /**
     * Create a new setting.
     *
     * @return array
     */
    public function createSetting(CreateSettingRequest $request)
    {
        $setting = Apiato::call('Settings@CreateSettingAction', [new DataTransporter($request)]);

        return $this->transform($setting, SettingTransformer::class);
    }

    /**
     * Updates an existing setting.
     *
     * @return array
     */
    public function updateSetting(UpdateSettingRequest $request)
    {
        $setting = Apiato::call('Settings@UpdateSettingAction', [$request]);

        return $this->transform($setting, SettingTransformer::class);
    }

    /**
     * Removes a setting.
     *
     * @return JsonResponse
     */
    public function deleteSetting(DeleteSettingRequest $request)
    {
        Apiato::call('Settings@DeleteSettingAction', [$request]);

        return $this->noContent();
    }
}
