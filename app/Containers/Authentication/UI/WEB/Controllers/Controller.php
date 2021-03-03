<?php

declare(strict_types=1);

namespace App\Containers\Authentication\UI\WEB\Controllers;

use App\Containers\Authentication\UI\WEB\Requests\LoginRequest;
use App\Containers\Authentication\UI\WEB\Requests\LogoutRequest;
use App\Containers\User\Models\User;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Controllers\WebController;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

/**
 * Class Controller.
 */
class Controller extends WebController
{
    /**
     * @return Factory|View
     */
    public function showLoginPage()
    {
        return view('authentication::login');
    }

    /**
     * @return RedirectResponse|Redirector
     */
    public function logout(LogoutRequest $request)
    {
        Apiato::call('Authentication@WebLogoutAction');

        Apiato::call('Authentication@WebSessionInvalidateAction', [$request]);

        return redirect(Apiato::getLoginWebPageName());
    }

    /**
     * @return RedirectResponse|Redirector
     */
    public function login(LoginRequest $request)
    {
        try {
            $user = Apiato::call('Authentication@WebLoginAction', [$request->toTransporter()]);

            Apiato::call('Authentication@WebSessionRegenerateAction', [$request]);
        } catch (Exception $e) {
            return redirect(Apiato::getLoginWebPageName())->with('status', $e->getMessage());
        }

        return $user instanceof User ? redirect()->intended() : redirect(Apiato::getLoginWebPageName());
    }
}
