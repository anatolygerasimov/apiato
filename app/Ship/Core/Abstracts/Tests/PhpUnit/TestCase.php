<?php

namespace App\Ship\Core\Abstracts\Tests\PhpUnit;

use App\Ship\Core\Traits\HashIdTrait;
use App\Ship\Core\Traits\TestCaseTrait;
use App\Ship\Core\Traits\TestsTraits\PhpUnit\TestsAuthHelperTrait;
use App\Ship\Core\Traits\TestsTraits\PhpUnit\TestsMockHelperTrait;
use App\Ship\Core\Traits\TestsTraits\PhpUnit\TestsMockInvestmentTrait;
use App\Ship\Core\Traits\TestsTraits\PhpUnit\TestsRequestHelperTrait;
use App\Ship\Core\Traits\TestsTraits\PhpUnit\TestsResponseHelperTrait;
use App\Ship\Core\Traits\TestsTraits\PhpUnit\TestsUploadHelperTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Illuminate\Foundation\Testing\TestCase as LaravelTestCase;
use Illuminate\Contracts\Console\Kernel;

/**
 * Class TestCase
 */
abstract class TestCase extends LaravelTestCase
{
    use TestCaseTrait,
        TestsRequestHelperTrait,
        TestsResponseHelperTrait,
        TestsMockHelperTrait,
        TestsMockInvestmentTrait,
        TestsAuthHelperTrait,
        TestsUploadHelperTrait,
        HashIdTrait,
        RefreshDatabase;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Setup the test environment, before each test.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Reset the test environment, after each test.
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Refresh the in-memory database.
     * Overridden refreshTestDatabase Trait
     *
     * @return void
     */
    protected function refreshInMemoryDatabase()
    {
        // migrate the database
        $this->migrateDatabase();

        // seed the database
        $this->seed();

        // Install Passport Client for Testing
        $this->setupPassportOAuth2();

        $this->app[Kernel::class]->setArtisan(null);
    }

    /**
     * Refresh a conventional test database.
     * Overridden refreshTestDatabase Trait
     *
     * @return void
     */
    protected function refreshTestDatabase()
    {
        if (!RefreshDatabaseState::$migrated) {

            $this->artisan('migrate:fresh');
            $this->seed();
            $this->setupPassportOAuth2();

            $this->app[Kernel::class]->setArtisan(null);

            RefreshDatabaseState::$migrated = true;
        }

        $this->beginDatabaseTransaction();
    }
}
