<?php

namespace App\Containers\Payment\Tasks;

use App\Containers\Payment\Models\AbstractPaymentAccount;
use App\Containers\User\Models\User;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AssignPaymentAccountToUserTask.
 */
class AssignPaymentAccountToUserTask extends Task
{
    /**
     * @return Model
     *
     * @throws CreateResourceFailedException
     */
    public function run(AbstractPaymentAccount $account, User $user, string $paymentNickName = null)
    {
        try {
            return $user->paymentAccounts()->create([
                'user_id'          => $user->id,
                'name'             => $paymentNickName,
                'accountable_id'   => $account->id,
                'accountable_type' => get_class($account),
            ]);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException();
        }
    }
}
