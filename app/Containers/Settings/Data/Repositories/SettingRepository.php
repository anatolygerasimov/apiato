<?php

declare(strict_types=1);

namespace App\Containers\Settings\Data\Repositories;

use App\Containers\Settings\Models\Setting;
use App\Ship\Parents\Repositories\Repository;

/**
 * Class SettingsRepository.
 */
class SettingRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id'  => '=',
        'key' => '=',
    ];

    /**
     * @return void
     */
    public function boot()
    {
        parent::boot();
        // probably do some stuff here ...
    }

    /**
     * @return string
     */
    public function model()
    {
        return Setting::class;
    }
}
