<?php

namespace App\Ship\Core\Commands;

use App\Ship\Core\Foundation\Apiato;
use App\Ship\Parents\Commands\ConsoleCommand;

/**
 * Class GetApiatoVersionCommand
 */
class GetApiatoVersionCommand extends ConsoleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "apiato";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Display the current Apiato version.";

    /**
     * GetApiatoVersionCommand constructor.
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
      $this->info(Apiato::VERSION);
    }
}
