<?php

namespace App\Containers\Payment\Tasks;

use App\Containers\Payment\Exceptions\PaymentAccountDoesNotBelongToUserException;
use App\Containers\Payment\Models\PaymentAccount;
use App\Containers\User\Models\User;
use App\Ship\Parents\Tasks\Task;

/**
 * Class CheckIfPaymentAccountBelongsToUserTask.
 */
class CheckIfPaymentAccountBelongsToUserTask extends Task
{
    /**
     * @return true
     *
     * @throws PaymentAccountDoesNotBelongToUserException
     */
    public function run(User $user, PaymentAccount $account): bool
    {
        if ($user->id !== $account->user_id) {
            throw new PaymentAccountDoesNotBelongToUserException();
        }

        return true;
    }
}
