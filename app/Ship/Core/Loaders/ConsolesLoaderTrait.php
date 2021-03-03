<?php

namespace App\Ship\Core\Loaders;

use App\Ship\Core\Foundation\Facades\Apiato;
use File;

/**
 * Class ConsolesLoaderTrait.
 */
trait ConsolesLoaderTrait
{
    private string $routeFile = 'Routes.php';

    /**
     * @param $containerName
     */
    public function loadConsolesFromContainers($containerName)
    {
        $containerCommandsDirectory = base_path('app/Containers/' . $containerName . '/UI/CLI/Commands');

        $this->loadTheConsoles($containerCommandsDirectory);
    }

    /**
     * @void
     */
    public function loadConsolesFromShip()
    {
        $commandsFoldersPaths = [
            // ship commands
            base_path('app/Ship/Commands'),
            // Core commands
            __DIR__ . '/../Commands',
        ];

        foreach ($commandsFoldersPaths as $folderPath) {
            $this->loadTheConsoles($folderPath);
        }
    }

    /**
     * @param $directory
     */
    private function loadTheConsoles($directory)
    {
        if (File::isDirectory($directory)) {

            $files = File::allFiles($directory);

            foreach ($files as $consoleFile) {

                // do not load route files
                if (!$this->isRouteFile($consoleFile)) {
                    $consoleClass = Apiato::getClassFullNameFromFile($consoleFile->getPathname());

                    // when user from the Main Service Provider, which extends Laravel
                    // service provider you get access to `$this->commands`
                    $this->commands([$consoleClass]);
                }
            }
        }
    }

    /**
     * @param $consoleFile
     *
     * @return bool
     */
    private function isRouteFile($consoleFile)
    {
        return $consoleFile->getFilename() === $this->routeFile;
    }
}
