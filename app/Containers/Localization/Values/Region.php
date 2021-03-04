<?php

namespace App\Containers\Localization\Values;

use App\Ship\Parents\Values\Value;
use Locale;

/**
 * Class Region.
 */
class Region extends Value
{
    private string $region;

    /**
     * A resource key to be used by the the JSON API Serializer responses.
     */
    protected string $resourceKey = 'regions';

    /**
     * Region constructor.
     */
    public function __construct(string $region)
    {
        $this->region = $region;
    }

    /**
     * @return string
     */
    public function getDefaultName()
    {
        return Locale::getDisplayRegion($this->region, config('app.locale'));
    }

    /**
     * @return string
     */
    public function getLocaleName()
    {
        return Locale::getDisplayRegion($this->region, $this->region);
    }

    public function getRegion(): string
    {
        return $this->region;
    }
}
