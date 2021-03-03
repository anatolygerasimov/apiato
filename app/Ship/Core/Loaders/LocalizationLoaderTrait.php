<?php

namespace App\Ship\Core\Loaders;

use App;
use File;

/**
 * Class LocalizationLoaderTrait
 */
trait LocalizationLoaderTrait
{

    /**
     * @param $containerName
     */
    public function loadLocalsFromContainers($containerName)
    {
        $containerMigrationDirectory = base_path('app/Containers/' . $containerName . '/Resources/Languages');

        $this->loadLocals($containerMigrationDirectory, $containerName);
    }

    /**
     * @void
     */
    public function loadLocalsFromShip()
    {
        // ..
    }

    /**
     * @param $directory
     * @param $containerName
     */
    private function loadLocals($directory, $containerName)
    {
        if (File::isDirectory($directory)) {

            $this->loadTranslationsFrom($directory, strtolower($containerName));

        }
    }

}
