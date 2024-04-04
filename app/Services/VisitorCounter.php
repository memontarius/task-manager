<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class VisitorCounter
{
    private readonly string $prefixKey;

    /**
     * @param int $monitoringPeriod Time in seconds
     */
    public function __construct(
        private readonly int $monitoringPeriod
    )
    {
        $this->prefixKey = env('CACHE_PREFIX') . ":visitor-";
    }

    public function handleEntrance(string $id): void
    {
        Redis::command('set', [$this->makeKey($id), '1', 'ex', $this->monitoringPeriod]);
    }

    public function getCount(): int
    {
        $visitors = Redis::command('keys', ["$this->prefixKey*"]);
        return count($visitors);
    }

    private function makeKey($uniqueId): string
    {
        return env('CACHE_PREFIX') . ":visitor-$uniqueId";
    }
}
