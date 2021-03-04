<?php

namespace App\Containers\Payment\Tasks;

use App\Containers\Payment\Data\Repositories\PaymentAccountRepository;
use App\Containers\Payment\Models\PaymentAccount;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

/**
 * Class DeletePaymentAccountTask.
 */
class DeletePaymentAccountTask extends Task
{
    protected PaymentAccountRepository $repository;

    public function __construct(PaymentAccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(PaymentAccount $account): bool
    {
        try {
            // first, get the associated account and remove this one!
            $account->accountable->delete();

            // then remove the payment account
            return (bool)$this->repository->delete($account->id);
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException();
        }
    }
}
