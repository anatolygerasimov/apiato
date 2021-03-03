<?php

/**
 * Add helper functions here
 */

use App\Containers\Settings\Models\Setting;
use App\Ship\Core\Foundation\Facades\Apiato;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

if (!function_exists('authGuardUser')) {

    function authGuardUser(): ?Authenticatable
    {
        return Auth::guard('api')->user();
    }
}

if (!function_exists('getSetting')) {

    /**
     * Get system configuration
     *
     * @param string $settingKey
     *
     * @return string
     */
    function getSetting(string $settingKey): string
    {
        /** @var Setting $setting */
        $setting = Apiato::call('Settings@FindSettingByKeyTask', [$settingKey]);
        return $setting->value;
    }
}

if (!function_exists('getSettingExample')) {

    /**
     * @return string
     */
    function getSettingExample()
    {
        return getSetting('get_setting_example');
    }
}
