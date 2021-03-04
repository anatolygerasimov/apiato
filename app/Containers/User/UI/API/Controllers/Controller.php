<?php

declare(strict_types=1);

namespace App\Containers\User\UI\API\Controllers;

use App\Containers\User\UI\API\Requests\CreateAdminRequest;
use App\Containers\User\UI\API\Requests\DeleteUserRequest;
use App\Containers\User\UI\API\Requests\EmailVerificationRequest;
use App\Containers\User\UI\API\Requests\FindUserByIdRequest;
use App\Containers\User\UI\API\Requests\ForgotPasswordRequest;
use App\Containers\User\UI\API\Requests\GetAllUsersRequest;
use App\Containers\User\UI\API\Requests\GetAuthenticatedUserRequest;
use App\Containers\User\UI\API\Requests\RegisterUserRequest;
use App\Containers\User\UI\API\Requests\ResendEmailVerificationRequest;
use App\Containers\User\UI\API\Requests\ResetPasswordRequest;
use App\Containers\User\UI\API\Requests\UpdatePasswordRequest;
use App\Containers\User\UI\API\Requests\UpdateUserEmailRequest;
use App\Containers\User\UI\API\Requests\UpdateUserRequest;
use App\Containers\User\UI\API\Transformers\UserProfileTransformer;
use App\Containers\User\UI\API\Transformers\UserTransformer;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

/**
 * Class Controller.
 */
class Controller extends ApiController
{
    public function registerUser(RegisterUserRequest $request): JsonResponse
    {
        $user = Apiato::transactionalCall('User@RegisterUserAction', [$request]);

        if (config('authentication-container.require_email_confirmation')) {
            return $this->accepted(['message' => 'Further instructions were sent to your email.']);
        }

        return $this->created($this->transform($user, UserTransformer::class));
    }

    /**
     * @return array
     */
    public function updateUser(UpdateUserRequest $request)
    {
        $user = Apiato::call('User@UpdateUserAction', [$request]);

        return $this->transform($user, UserTransformer::class);
    }

    /**
     * @return JsonResponse
     */
    public function deleteUser(DeleteUserRequest $request)
    {
        Apiato::call('User@DeleteUserAction', [$request]);

        return $this->noContent();
    }

    /**
     * @return array
     */
    public function getAllUsers(GetAllUsersRequest $request)
    {
        $users = Apiato::call('User@GetAllUsersAction');

        return $this->transform($users, UserTransformer::class);
    }

    /**
     * @return array
     */
    public function findUserById(FindUserByIdRequest $request)
    {
        $user = Apiato::call('User@FindUserByIdAction', [$request]);

        return $this->transform($user, UserTransformer::class);
    }

    /**
     * @return array
     */
    public function getAuthenticatedUser(GetAuthenticatedUserRequest $request)
    {
        $user = Apiato::call('User@GetAuthenticatedUserAction');

        return $this->transform($user, UserProfileTransformer::class);
    }

    /**
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
      Apiato::call('User@ResetPasswordAction', [$request]);

        return $this->noContent();
    }

    /**
     * @return JsonResponse
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $status = Apiato::call('User@ForgotPasswordAction', [$request]);

        // We have e-mailed your password reset link.
        return $this->json(['message' => $status]);
    }

    /**
     * @return JsonResponse
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        Apiato::call('User@UpdatePasswordAction', [$request]);

        return $this->accepted(['message' => 'Password successfully changed.']);
    }

    /**
     * @return array
     */
    public function createAdmin(CreateAdminRequest $request)
    {
        $admin = Apiato::call('Orchid@CreateAdminAction', [$request]);

        return $this->transform($admin, UserTransformer::class);
    }

    /**
     * @return array
     */
    public function getAllClients(GetAllUsersRequest $request)
    {
        $users = Apiato::call('User@GetAllClientsAction');

        return $this->transform($users, UserTransformer::class);
    }

    /**
     * @return array
     */
    public function getAllAdmins(GetAllUsersRequest $request)
    {
        $users = Apiato::call('Orchid@GetAllAdminsAction');

        return $this->transform($users, UserTransformer::class);
    }

    /**
     * @return JsonResponse
     */
    public function verifyUserEmail(EmailVerificationRequest $request)
    {
        Apiato::call('User@EmailVerificationAction', [$request]);

        return $this->accepted(['message' => 'Your email was successfully verified.']);
    }

    /**
     * @return JsonResponse
     */
    public function resendUserEmail(ResendEmailVerificationRequest $request)
    {
        $isEmailResend = Apiato::call('User@ResendEmailVerificationAction');

        if ($isEmailResend) {
            return $this->accepted(['message' => 'Email verification link sent on your email.']);
        }

        return $this->noContent();
    }

    /**
     * @return JsonResponse
     */
    public function updateUserEmail(UpdateUserEmailRequest $request)
    {
        Apiato::call('User@UpdateUserEmailAction', [$request]);

        return $this->accepted(['message' => 'Email verification link sent on your email.']);
    }
}
