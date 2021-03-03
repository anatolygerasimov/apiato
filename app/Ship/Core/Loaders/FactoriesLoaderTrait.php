<?php

namespace App\Ship\Core\Loaders;

use App;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;

/**
 * Class FactoriesLoaderTrait.
 */
trait FactoriesLoaderTrait
{

    /**
     * By default Laravel takes a shared factory directory to load from it all the factories.
     * This function changes the path to load the factories from the port directory instead.
     */
    public function loadFactoriesFromContainers()
    {
        $loadersDirectory = dirname(realpath(__FILE__));

        $newFactoriesPath = $loadersDirectory . '/FactoryMixer';

        App::singleton(Factory::class, function ($app) use ($newFactoriesPath) {
//            $factory = Factory::new();
//            $factory::useNamespace($newFactoriesPath);
//            return $factory;
            $faker = $app->make(Generator::class);
            return Factory::construct($faker, $newFactoriesPath);
        });
    }

}
