<?php

namespace App\Containers\Localization\Values;

use App\Ship\Parents\Values\Value;
use Locale;

/**
 * Class Localization.
 */
class Localization extends Value
{
    private string $language;

    private array $regions = [];

    /**
     * A resource key to be used by the the JSON API Serializer responses.
     */
    protected string $resourceKey = 'localizations';

    /**
     * Localization constructor.
     */
    public function __construct(string $language, array $regions = [])
    {
        $this->language = $language;

        foreach ($regions as $region) {
            $this->regions[] = new Region($region);
        }
    }

    /**
     * @return string
     */
    public function getDefaultName()
    {
        return Locale::getDisplayLanguage($this->language, config('app.locale'));
    }

    /**
     * @return string
     */
    public function getLocaleName()
    {
        return Locale::getDisplayLanguage($this->language, $this->language);
    }

    /**
     * @return string|null
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return array
     */
    public function getRegions()
    {
        return $this->regions;
    }
}
