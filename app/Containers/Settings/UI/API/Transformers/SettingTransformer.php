<?php

declare(strict_types=1);

namespace App\Containers\Settings\UI\API\Transformers;

use App\Containers\Settings\Models\Setting;
use App\Ship\Parents\Transformers\Transformer;

class SettingTransformer extends Transformer
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

    /**
     * @return array
     */
    public function transform(Setting $entity)
    {
        $response = [

            'object' => 'Setting',
            'id'     => $entity->getHashedKey(),

            'key'   => $entity->key,
            'value' => $entity->value,
        ];

        return $this->ifAdmin([
            'real_id' => $entity->id,
        ], $response);
    }
}
