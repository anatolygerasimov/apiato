<?php

namespace App\Containers\Debugger\Values;

use App\Ship\Parents\Values\Value;
use Illuminate\Support\Facades\App;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class RequestsLogger.
 */
class RequestsLogger extends Value
{
    public const TESTING_ENV = 'testing';

    protected bool $debuggingEnabled;

    /**
     * @var null|bool|string
     */
    protected $environment;

    protected ?Logger $logger = null;

    protected string $logFile;

    /**
     * RequestsLogger constructor.
     */
    public function __construct()
    {
        $this->prepareConfigs();
        $this->prepareLogger();
    }

    public function releaseOutput(Output $output): void
    {
        if ($this->environment !== self::TESTING_ENV && $this->debuggingEnabled === true && $this->logger) {
            $this->logger->info($output->get());
        }
    }

    private function prepareConfigs(): void
    {
        $this->environment      = App::environment();
        $this->debuggingEnabled = (bool)config('debugger.requests.debug');
        $this->logFile          = config('debugger.requests.log_file');
    }

    private function prepareLogger(): void
    {
        $handler = new StreamHandler(storage_path('logs/' . $this->logFile));
        $handler->setFormatter(new LineFormatter(null, null, true, true));

        $this->logger = new Logger('REQUESTS DEBUGGER');
        $this->logger->pushHandler($handler);
    }
}
