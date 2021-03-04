<?php

namespace App\Containers\Payment\Tasks;

use App\Containers\Payment\Data\Repositories\PaymentAccountRepository;
use App\Containers\Payment\Models\PaymentAccount;
use App\Ship\Core\Traits\TaskTraits\FilterByUserRepositoryTrait;
use App\Ship\Criterias\Eloquent\OrderByCreationDateDescendingCriteria;
use App\Ship\Parents\Repositories\Repository;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class GetAllPaymentAccountsTask.
 */
class GetAllPaymentAccountsTask extends Task
{
    use FilterByUserRepositoryTrait;

    protected PaymentAccountRepository $repository;

    /**
     * GetAllPaymentAccountsTask constructor.
     */
    public function __construct(PaymentAccountRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Collection|array<array-key, PaymentAccount>
     */
    public function run()
    {
        return $this->repository->paginate();
    }

    public function ordered(): Repository
    {
        return $this->repository->pushCriteria(new OrderByCreationDateDescendingCriteria());
    }
}
