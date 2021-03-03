<?php

declare(strict_types=1);

namespace App\Ship\Middlewares\Http;

use Closure;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;
use Illuminate\Log\LogManager;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

final class QueryStatsHeaders
{
    private DatabaseManager $databaseManager;
    private LogManager $logger;
    private int $responseQueryCut = 200;

    public function __construct(DatabaseManager $databaseManager, LogManager $logger)
    {
        $this->databaseManager = $databaseManager;
        $this->logger          = $logger;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $this->handleInternal($response, $this->databaseManager);

        return $response;
    }

    private function handleInternal(Response $response, DatabaseManager $databaseManager): void
    {
        $queryLog = $databaseManager->getQueryLog();
        $this->addHeaders($response, $queryLog);
    }

    private function addHeaders(Response $response, array $queryLog): void
    {
        $time     = $this->getQueryTime($queryLog);
        $count    = $this->getQueryCount($queryLog);
        $slowest  = $this->getSlowestQuery($queryLog);
        $frequent = $this->getMostFrequentQuery($queryLog);

        $response->headers->set('X-Query-Time', sprintf('%sms', $time));
        $response->headers->set('X-Query-Count', (string)$count);
        $response->headers->set('X-Query-Slowest', sprintf('%s - %sms', $slowest['query'], $slowest['time']));
        $response->headers->set('X-Query-Frequent', sprintf('%s - %s', key($frequent), current($frequent)));
    }

    private function getQueryTime(array $queryLog): float
    {
        $times = array_column($queryLog, 'time');

        return array_sum($times);
    }

    private function getQueryCount(array $queryLog): int
    {
        return count($queryLog);
    }

    private function getSlowestQuery(array $queryLog): array
    {
        $result = Collection::make($queryLog)->sort(static fn($prev, $next) => $prev['time'] <=> $next['time'])->last();
        $result = empty($result) ? ['query' => '...','time' => 0] : $result;
        $result['query'] = strlen($result['query']) > $this->responseQueryCut ? substr($result['query'], 0, $this->responseQueryCut) . '...' : $result['query'];
        return $result;
    }

    private function getMostFrequentQuery(array $queryLog): array
    {
        $result = Collection::make($queryLog)->groupBy('query')->map(static fn($query) => $query->count())->sortDesc()->take(1)->toArray();
        $result = empty($result) ? ['empty' => 'empty'] : $result;
        return $result;
    }
}