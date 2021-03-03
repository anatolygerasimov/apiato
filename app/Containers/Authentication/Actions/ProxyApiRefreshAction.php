<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Actions;

use App\Containers\Authentication\Data\Transporters\ProxyRefreshTransporter;
use App\Containers\Authentication\Exceptions\RefreshTokenMissedException;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class ProxyApiRefreshAction.
 */
class ProxyApiRefreshAction extends Action
{
    /**
     * @return array{response_content: mixed, refresh_cookie: mixed}
     */
    public function run(ProxyRefreshTransporter $data): array
    {
        if (!$data->refresh_token) {
            throw new RefreshTokenMissedException();
        }

        $requestData = [
            'grant_type'    => $data->grant_type,
            'refresh_token' => $data->refresh_token,
            'client_id'     => $data->client_id,
            'client_secret' => $data->client_password,
            'scope'         => $data->scope,
        ];

        $responseContent = Apiato::call('Authentication@CallOAuthServerTask', [$requestData]);

        $refreshCookie = Apiato::call('Authentication@MakeRefreshCookieTask', [$responseContent['refresh_token']]);

        return [
            'response_content' => $responseContent,
            'refresh_cookie'   => $refreshCookie,
        ];
    }
}
