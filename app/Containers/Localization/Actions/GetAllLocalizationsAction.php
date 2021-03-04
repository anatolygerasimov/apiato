<?php

namespace App\Containers\Localization\Actions;

use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

/**
 * Class GetAllLocalizationsAction.
 */
class GetAllLocalizationsAction extends Action
{
    public function run(): Collection
    {
        return Apiato::call('Localization@GetAllLocalizationsTask');
    }
}
