<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Actions;

use App\Containers\Authentication\Data\Transporters\LoginTransporter;
use App\Containers\Authentication\Data\Transporters\ProxyApiLoginTransporter;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use Dto\Exceptions\InvalidDataTypeException;

/**
 * Class ProxyApiLoginAction.
 */
class ProxyApiLoginAction extends Action
{
    /**
     * @return array{response_content: mixed, refresh_cookie: mixed}
     *
     * @throws InvalidDataTypeException
     */
    public function run(ProxyApiLoginTransporter $data): array
    {
        $loginCustomAttribute = Apiato::call('Authentication@ExtractLoginCustomAttributeTask', [$data]);

        $requestData = [
            'username'      => $loginCustomAttribute['username'],
            'client_ip'     => $data->client_ip,
            'password'      => $data->password,
            'grant_type'    => $data->grant_type,
            'client_id'     => $data->client_id,
            'client_secret' => $data->client_password,
            'scope'         => $data->scope,
        ];

        $responseContent = Apiato::call('Authentication@CallOAuthServerTask', [$requestData]);

        // Now we check if user email is confirmed only if that feature is enabled.
        Apiato::call('Authentication@LoginSubAction', [new LoginTransporter($data->toArray())]);

        $refreshCookie = Apiato::call('Authentication@MakeRefreshCookieTask', [$responseContent['refresh_token']]);

        return [
            'response_content' => $responseContent,
            'refresh_cookie'   => $refreshCookie,
        ];
    }
}
