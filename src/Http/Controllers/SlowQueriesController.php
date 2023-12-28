<?php

namespace WebduoNederland\PulseApi\Http\Controllers;

use Carbon\CarbonInterval;
use Illuminate\Http\JsonResponse;
use Laravel\Pulse\Facades\Pulse;
use WebduoNederland\PulseApi\Actions\Interval;

class SlowQueriesController
{
    public function __construct(
        public Interval $intervalAction
    ) {
        //
    }

    public function __invoke(): JsonResponse
    {
        $interval = request()->input('interval', 1);

        if (! $this->intervalAction->isValid($interval)) {
            return response()->json([
                'success' => false,
                'message' => __('Interval should be one of these hours: ').implode(', ', $this->intervalAction->allowedIntervals),
            ], 400);
        }

        $data = Pulse::aggregate(
            'slow_query',
            ['max', 'count'],
            CarbonInterval::hours(intval($interval))
        )->map(function ($entry): array {
            [$sql, $location] = json_decode($entry->key);

            return [
                'sql' => $sql,
                'location' => $location,
                'count' => intval($entry->count),
                'slowest' => intval($entry->max),
            ];
        })
            ->toArray();

        return response()->json($data);
    }
}
