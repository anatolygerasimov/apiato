<?php

namespace App\Containers\SocialAuth\UI\API\Controllers;

use App\Containers\SocialAuth\Data\Transporters\ApiAuthenticateTransporter;
use App\Containers\SocialAuth\UI\API\Requests\ApiAuthenticateRequest;
use App\Containers\User\UI\API\Transformers\UserTransformer;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Controllers\ApiController;

/**
 * Class Controller.
 */
class Controller extends ApiController
{
    /**
     * @param string $providerUrlInput
     *
     * @return array
     */
    public function authenticateAll(ApiAuthenticateRequest $request, $providerUrlInput)
    {
        $dataTransporter           = new ApiAuthenticateTransporter($request);
        $dataTransporter->provider = $providerUrlInput;

        $data = Apiato::call('SocialAuth@SocialLoginAction', [$dataTransporter]);

        return $this->transform($data['user'], UserTransformer::class, [], [
            'token_type'   => 'personal',
            'access_token' => $data['token']->accessToken,
        ]);
    }
}
