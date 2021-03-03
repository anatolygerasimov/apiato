<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Tasks;

use App\Containers\Authentication\Exceptions\LoginFailedException;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Tasks\Task;
use GuzzleHttp\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

/**
 * Class CallOAuthServerTask.
 */
class CallOAuthServerTask extends Task
{
    /**
     * @string
     */
    private const AUTH_ROUTE = 'v1/oauth/token';

    /**
     * @throws LoginFailedException
     */
    public function run(array $data): array
    {
        $headers = [
            'HTTP_ACCEPT'          => 'application/json',
            'HTTP_X_FORWARDED_FOR' => $data['client_ip'],
        ];

        // Create and handle the oauth request
        $request = Request::create($this->getAuthFullApiUrl(), 'POST', $data, [], [], $headers);

        $response = App::handle($request);

        // response content as Array
        $content = Utils::jsonDecode($response->getContent(), true);

        // If the internal request to the oauth token endpoint was not successful we throw an exception
        if (!$response->isSuccessful()) {
            throw new LoginFailedException(
                'Login failed: Invalid username or password',
                null,
                $response->getStatusCode()
            );
        }

        return (array)$content;
    }

    /**
     * Full url to the oauth token endpoint.
     */
    private function getAuthFullApiUrl(): string
    {
        return config('apiato.api.url') . Apiato::getApiPrefix() . self::AUTH_ROUTE;
    }
}
