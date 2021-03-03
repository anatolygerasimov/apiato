<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Tasks;

use App\Ship\Parents\Tasks\Task;
use Illuminate\Cookie\CookieJar;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Class MakeRefreshCookieTask.
 */
class MakeRefreshCookieTask extends Task
{
    /**
     * @link https://www.chromestatus.com/feature/5633521622188032
     *
     * @return Cookie|CookieJar
     */
    public function run(?string $refreshToken)
    {
        // Save the refresh token in a HttpOnly cookie to minimize the risk of XSS attacks
        return cookie(
            'refreshToken',
            $refreshToken,
            config('apiato.api.refresh-expires-in'),
            config('session.path'),
            config('session.domain'),
            config('app.env') === 'local' ? false : config('session.secure'),
            config('session.http_only'),
            config('session.raw'),
            config('session.same_site'),
        );
    }
}
