<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Tests;

use App\Containers\Authentication\Tests\TestCase as BaseTestCase;

/**
 * Class WebTestCase.
 *
 * Container Web TestCase class. Use this class to put your Web container specific tests helper functions.
 */
class WebTestCase extends BaseTestCase
{
    public function setUp(): void
    {
        // change the API_PREFIX for web tests
        putenv('API_PREFIX=api');

        parent::setUp();
    }

    public function tearDown(): void
    {
        // revert the API_PREFIX variable to null to avoid effects on other test
        putenv('API_PREFIX=');

        parent::tearDown();
    }
}
