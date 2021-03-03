<?php

namespace App\Ship\Core\Traits\TestsTraits\PhpUnit;

use App;
use Mockery;
use Mockery\MockInterface;

/**
 * Class TestsMockHelperTrait
 *
 * Tests helper for mocking objects and services.
 */
trait TestsMockHelperTrait
{
    /**
     * Mocking helper
     *
     * @param $class
     *
     * @return MockInterface
     */
    public function mockIt($class)
    {
        $mock = Mockery::mock($class);
        App::instance($class, $mock);

        return $mock;
    }
}
