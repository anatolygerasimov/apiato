<?php

namespace App\Ship\Core\Commands;

use App\Ship\Parents\Commands\ConsoleCommand;
use App\Ship\Seeders\SeedDeploymentData;

/**
 * Class SeedDeploymentDataCommand
 */
class SeedDeploymentDataCommand extends ConsoleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apiato:seed-deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed data for initial deployment.';

    /**
     * SeedTestingDataCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Handle the command
     */
    public function handle()
    {
        $this->call('db:seed', [
            '--class' => SeedDeploymentData::class,
        ]);

        $this->info('Deployment Data Seeded Successfully.');
    }
}
