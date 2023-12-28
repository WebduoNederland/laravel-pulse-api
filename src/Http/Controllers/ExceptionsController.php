<?php

namespace WebduoNederland\PulseApi\Http\Controllers;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;
use Illuminate\Http\JsonResponse;
use Laravel\Pulse\Facades\Pulse;
use WebduoNederland\PulseApi\Actions\Interval;

class ExceptionsController
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
            'exception',
            ['max', 'count'],
            CarbonInterval::hours(intval($interval))
        )->map(function ($entry): array {
            [$class, $location] = json_decode($entry->key);

            return [
                'class' => $class,
                'location' => $location,
                'count' => intval($entry->count),
                'latest' => CarbonImmutable::createFromTimestamp($entry->max),
            ];
        })
            ->toArray();

        return response()->json($data);
    }
}
