<?php

namespace WebduoNederland\PulseApi\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Laravel\Pulse\Facades\Pulse;

class System
{
    public function getSystem(string $name): ?array
    {
        $now = now();

        return Pulse::values('system')
            ->where('key', '=', $name)
            ->map(function ($system) use ($now): array {
                $systemData = json_decode($system->value, true);

                return [
                    'name' => $system->key,
                    'running' => $this->isSystemRunning($now, $system->timestamp),
                    'data' => Arr::except($systemData, 'name'),
                ];
            })
            ->first();
    }

    public function getSystems(bool $onlyRunning = false): Collection
    {
        $now = now();

        return Pulse::values('system')
            ->map(function ($system) use ($now): array {
                $systemData = json_decode($system->value, true);

                return [
                    'name' => $system->key,
                    'running' => $this->isSystemRunning($now, $system->timestamp),
                    'data' => Arr::except($systemData, 'name'),
                ];
            })
            ->when($onlyRunning, fn ($result) => $result->where('running', '=', true));
    }

    protected function isSystemRunning(Carbon $now, int $timestamp): bool
    {
        $lastHeartbeat = Carbon::createFromTimestamp($timestamp);

        if ($now->diffInSeconds($lastHeartbeat) < 20) {
            return true;
        }

        return false;
    }
}
