<?php

declare(strict_types=1);

namespace App\Containers\Authentication\UI\API\Controllers;

use App\Containers\Authentication\Data\Transporters\ProxyApiLoginTransporter;
use App\Containers\Authentication\Data\Transporters\ProxyRefreshTransporter;
use App\Containers\Authentication\UI\API\Requests\LoginRequest;
use App\Containers\Authentication\UI\API\Requests\LogoutRequest;
use App\Containers\Authentication\UI\API\Requests\RefreshRequest;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cookie;

/**
 * Class Controller.
 */
class Controller extends ApiController
{
    public function logoutForApiClient(LogoutRequest $request): JsonResponse
    {
        Apiato::call('Authentication@ApiLogoutAction');

        return $this->accepted([
            'message' => 'Token revoked successfully.',
        ])->withCookie(Cookie::forget('refreshToken'));
    }

    /**
     * This `proxyLoginForApiClient` exist only because we have `ApiClient`
     * The more clients (Web Apps). Each client you add in the future, must have
     * similar functions here, with custom route for dedicated for each client
     * to be used as proxy when contacting the OAuth server.
     * This is only to help the Web Apps (JavaScript clients) hide
     * their ID's and Secrets when contacting the OAuth server and obtain Tokens.
     */
    public function proxyLoginForApiClient(LoginRequest $request): JsonResponse
    {
        $dataTransporter = new ProxyApiLoginTransporter(
            array_merge($request->all(), [
                'client_ip'       => $request->ip(),
                'client_id'       => config('authentication-container.clients.api.user.id'),
                'client_password' => config('authentication-container.clients.api.user.secret'),
            ])
        );

        $result = Apiato::call('Authentication@ProxyApiLoginAction', [$dataTransporter]);

        return $this->json($result['response_content'])->withCookie($result['refresh_cookie']);
    }

    /**
     * Read the comment in the function `proxyLoginForApiClient`.
     */
    public function proxyRefreshForApiClient(RefreshRequest $request): JsonResponse
    {
        $dataTransporter = new ProxyRefreshTransporter(
            array_merge($request->all(), [
                'client_id'       => config('authentication-container.clients.api.user.id'),
                'client_password' => config('authentication-container.clients.api.user.secret'),
                // use the refresh token sent in request data, if not exist try to get it from the cookie
                'refresh_token'   => $request->refresh_token ?: $request->cookie('refreshToken'),
            ])
        );

        $result = Apiato::call('Authentication@ProxyApiRefreshAction', [$dataTransporter]);

        return $this->json($result['response_content'])->withCookie($result['refresh_cookie']);
    }
}
