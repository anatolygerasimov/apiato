<?php

namespace App\Containers\Stripe\Tests\Unit;

use App\Containers\Payment\Models\PaymentTransaction;
use App\Containers\Payment\Tasks\AssignPaymentAccountToUserTask;
use App\Containers\Stripe\Models\StripeAccount;
use App\Containers\Stripe\Tasks\ChargeWithStripeTask;
use App\Containers\User\Tests\TestCase;
use Illuminate\Support\Facades\App;

/**
 * Class ChargeUserWithStripeTest.
 *
 * @group stripe
 * @group unit
 */
class ChargeUserWithStripeTest extends TestCase
{
    /**
     * @test
     */
    public function testChargeUserWithStripe(): void
    {
        // Mock the payments
        $this->mockPayments();

        // create testing user
        $user = $this->getTestingUser();

        $stripeAccount = factory(StripeAccount::class)->create([
            'customer_id' => 'cus_8mBD5S1SoyD4zL',
        ]);

        App::make(AssignPaymentAccountToUserTask::class)->run($stripeAccount, $user, 'nickname');

        $amount = 100;

        // Start the test:
        $account = $user->paymentAccounts->first();

        $transaction = $user->charge($account, $amount);

        $this->assertEquals($transaction->gateway, 'Stripe');
    }

    public function mockPayments(): void
    {
        // Mock Stripe charging
        if (class_exists($chargeWithStripeTask = ChargeWithStripeTask::class)) {

            /** @var array<array-key, mixed> $paymentTransaction */
            $paymentTransaction = new PaymentTransaction([
                'user_id' => 1,

                'gateway'        => 'Stripe',
                'transaction_id' => 'tx_1234567890',
                'status'         => 'success',
                'is_successful'  => true,

                'amount'   => '100',
                'currency' => 'USD',

                'data'   => [],
                'custom' => [],
            ]);

            /** @psalm-suppress UndefinedMagicMethod */
            $this->mockIt($chargeWithStripeTask)
                ->shouldReceive('charge')
                ->andReturn($paymentTransaction);
        }
    }
}
