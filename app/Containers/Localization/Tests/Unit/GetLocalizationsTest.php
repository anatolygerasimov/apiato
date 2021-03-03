<?php

namespace App\Containers\Localization\Tests\Unit;

use App\Containers\Localization\Tasks\GetAllLocalizationsTask;
use App\Containers\Localization\Tests\TestCase;
use App\Containers\Localization\Values\Localization;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

/**
 * Class GetLocalizationsTest.
 *
 * @group localization
 * @group unit
 */
class GetLocalizationsTest extends TestCase
{
    /**
     * @test
     */
    public function testIfAllSupportedLanguagesAreReturned()
    {
        $class         = App::make(GetAllLocalizationsTask::class);
        $localizations = $class->run();

        $configuredLocalizations = Config::get('localization-container.supported_languages', []);

        // assert that they have the same amount of fields
        $this->assertEquals(count($configuredLocalizations), $localizations->count());

        // now we check all localizations in particular
    }

    public function testIfSpecificLocaleIsReturned()
    {
        $class         = App::make(GetAllLocalizationsTask::class);
        $localizations = $class->run();

        $unsupportedLocale = new Localization('fr');

        $this->assertContainsEquals($unsupportedLocale, $localizations);
    }

    public function testIfSpecificLocaleWithRegionsIsReturned()
    {
        $class         = App::make(GetAllLocalizationsTask::class);
        $localizations = $class->run();

        $unsupportedLocale = new Localization('en', ['en-GB', 'en-US']);

        $this->assertContainsEquals($unsupportedLocale, $localizations);
    }

    public function testIfWrongLocaleIsNotReturned()
    {
        $class         = App::make(GetAllLocalizationsTask::class);
        $localizations = $class->run();

        $unsupportedLocale = new Localization('xxx');

        $this->assertNotContainsEquals($unsupportedLocale, $localizations);
    }
}
