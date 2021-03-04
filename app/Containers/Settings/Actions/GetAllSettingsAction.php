<?php

declare(strict_types=1);

namespace App\Containers\Settings\Actions;

use App\Containers\Settings\Models\Setting;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class GetAllSettingsAction.
 */
class GetAllSettingsAction extends Action
{
    /**
     * @return Setting[]|Collection
     */
    public function run()
    {
        return Apiato::call('Settings@GetAllSettingsTask', [], ['addRequestCriteria', 'ordered']);
    }
}
