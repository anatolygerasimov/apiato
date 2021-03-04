<?php

namespace App\Containers\Payment\UI\API\Controllers;

use App\Containers\Payment\UI\API\Requests\DeletePaymentAccountRequest;
use App\Containers\Payment\UI\API\Requests\FindPaymentAccountRequest;
use App\Containers\Payment\UI\API\Requests\GetAllPaymentAccountsRequest;
use App\Containers\Payment\UI\API\Requests\UpdatePaymentAccountRequest;
use App\Containers\Payment\UI\API\Transformers\PaymentAccountTransformer;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

/**
 * Class Controller.
 */
class Controller extends ApiController
{
    /**
     * @return array
     */
    public function getAllPaymentAccounts(GetAllPaymentAccountsRequest $request)
    {
        $paymentAccounts = Apiato::call('Payment@GetAllPaymentAccountsAction');

        return $this->transform($paymentAccounts, PaymentAccountTransformer::class);
    }

    /**
     * @return array
     */
    public function getPaymentAccount(FindPaymentAccountRequest $request)
    {
        $paymentAccount = Apiato::call('Payment@FindPaymentAccountDetailsAction', [$request]);

        return $this->transform($paymentAccount, PaymentAccountTransformer::class);
    }

    /**
     * @return array
     */
    public function updatePaymentAccount(UpdatePaymentAccountRequest $request)
    {
        $paymentAccount = Apiato::call('Payment@UpdatePaymentAccountAction', [$request]);

        return $this->transform($paymentAccount, PaymentAccountTransformer::class);
    }

    /**
     * @return JsonResponse
     */
    public function deletePaymentAccount(DeletePaymentAccountRequest $request)
    {
        Apiato::call('Payment@DeletePaymentAccountAction', [$request]);

        return $this->noContent();
    }
}
