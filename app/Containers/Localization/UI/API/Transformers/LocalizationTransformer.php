<?php

namespace App\Containers\Localization\UI\API\Transformers;

use App\Containers\Localization\Values\Localization;
use App\Ship\Parents\Transformers\Transformer;

/**
 * Class LocalizationTransformer.
 */
class LocalizationTransformer extends Transformer
{
    /**
     * @var array
     */
    protected $defaultIncludes = [

    ];

    /**
     * @var array
     */
    protected $availableIncludes = [

    ];

    public function transform(Localization $entity): array
    {
        $response = [
            'object' => 'Localization',
            'id'     => $entity->getLanguage(),

            'language' => [
                'code'         => $entity->getLanguage(),
                'default_name' => $entity->getDefaultName(),
                'locale_name'  => $entity->getLocaleName(),
            ],
        ];

        // now we manually build the regions
        $regions        = [];
        $entity_regions = $entity->getRegions();

        foreach ($entity_regions as $region) {
            $regions[] = [
                'code'         => $region->getRegion(),
                'default_name' => $region->getDefaultName(),
                'locale_name'  => $region->getLocaleName(),
            ];
        }

        // now add the regions
        $response = array_merge($response, [
            'regions' => $regions,
        ]);

        return $this->ifAdmin([

        ], $response);
    }
}
