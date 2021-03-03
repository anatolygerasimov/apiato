<?php

namespace App\Ship\Core\Transformers;

use App\Ship\Core\Abstracts\Transformers\Transformer;
use stdClass;

/**
 * Class ComposerTransformer
 */
class ComposerTransformer extends Transformer
{
    /**
     * @param stdClass $decodedJson
     *
     * @return array
     */
    public function transform(stdClass $decodedJson)
    {
        $result = [
            'name'        => $decodedJson->name,
            'description' => $decodedJson->name,
        ];

        if (isset($decodedJson->type)) {
            $result['type'] = $decodedJson->type;
        }

        if (isset($decodedJson->support)) {
            $result['support'] = (array)$decodedJson->support;
        }

        return $result;
    }
}
