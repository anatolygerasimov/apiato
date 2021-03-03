<?php

declare(strict_types=1);

namespace App\Containers\Authentication\UI\API\Transformers;

use App\Ship\Parents\Transformers\Transformer;

/**
 * Class TokenTransformer.
 */
class TokenTransformer extends Transformer
{
    /**
     * @psalm-return array{object: string, access_token: string, token_type: string, expires_in: \Illuminate\Config\Repository|mixed}
     */
    public function transform(string $token): array
    {
        return [
            'object'       => 'Token',
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => config('apiato.api.expires-in'),
        ];
    }
}
