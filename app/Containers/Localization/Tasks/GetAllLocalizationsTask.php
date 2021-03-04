<?php

namespace App\Containers\Localization\Tasks;

use App\Containers\Localization\Values\Localization;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

/**
 * Class GetAllLocalizationsTask.
 */
class GetAllLocalizationsTask extends Task
{
    public function run(): Collection
    {
        $supported_localizations = config('localization-container.supported_languages');

        if (!is_array($supported_localizations)) {
            return collect();
        }

        $localizations = new Collection();

        foreach ($supported_localizations as $key => $value) {
            // it is a simple key
            if (!is_array($value)) {
                $localizations->push(new Localization($value));
            } else { // it is a composite key
                $localizations->push(new Localization($key, $value));
            }
        }

        return $localizations;
    }
}
