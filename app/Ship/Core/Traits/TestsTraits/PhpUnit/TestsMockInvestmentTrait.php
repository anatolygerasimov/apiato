<?php

namespace App\Ship\Core\Traits\TestsTraits\PhpUnit;

use App\Containers\Factor\Models\Factor;
use App\Containers\Investment\Models\Investment;
use App\Containers\Process\Data\Transporters\SyncProcessFactorTransporter;
use App\Containers\Process\Models\Process;
use App\Containers\User\Models\User;
use App\Ship\Core\Foundation\Facades\Apiato;
use Illuminate\Database\Eloquent\Collection;

/**
 * Tests helper for mocking Investment
 * Class TestsMockInvestmentTrait.
 */
trait TestsMockInvestmentTrait
{
    public ?array $processIds = null;

    public ?Investment $investment = null;

    /**
     * @var Collection
     */
    public $processes = null;

    /**
     * @var Collection|null
     */
    private $investmentProcesses = null;

    /**
     * @var Collection|null
     */
    private $investmentFactors = null;

    public function mockInvestment(User $user, array $states = []): void
    {
        $this->prepareProcessesAndInvestment($states);

        $this->processIds = $this->processes->modelKeys();

        $this->investmentProcesses = Apiato::call('InvestmentItem@AttachInvestmentProcessesSubAction', [$this->investment, $this->processIds], [['setUser' => [$user]]]);

        $this->investmentFactors = Apiato::call('InvestmentItem@AttachInvestmentFactorSubAction', [$this->investmentProcesses], [['setUser' => [$user]]]);
    }

    public function prepareProcessesAndInvestment(array $states = []): void
    {
        $investmentStates = array_merge(['add_user', 'meta_info'], $states);

        $this->investment = factory(Investment::class)->states($investmentStates)->create();
        $this->processes  = factory(Process::class, 5)->states(['add_user', 'active'])->create();

        /** @var Collection $factors */
        $factors = factory(Factor::class, 6)->create();

        $firstProcess = $this->processes->first();
        $lastProcess  = $this->processes->last();

        $processFactorData = [
            'factor_ids' => $factors->modelKeys(),
            'process_id' => $firstProcess ? $firstProcess->id : null,
        ];

        Apiato::call('Process@AttachProcessFactorAction', [new SyncProcessFactorTransporter($processFactorData)]);

        $processFactorData = [
            'factor_ids' => $factors->modelKeys(),
            'process_id' => $lastProcess ? $lastProcess->id : null,
        ];

        Apiato::call('Process@AttachProcessFactorAction', [new SyncProcessFactorTransporter($processFactorData)]);
    }

    public function getInvestmentProcesses(): Collection
    {
        $this->investmentProcesses ??= Collection::empty();

        return $this->investmentProcesses;
    }

    public function getInvestmentFactors(): Collection
    {
        $this->investmentFactors ??= Collection::empty();

        return $this->investmentFactors;
    }
}
