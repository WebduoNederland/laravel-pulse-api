<?php

namespace WebduoNederland\PulseApi\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use WebduoNederland\PulseApi\Actions\System;

class StatusController extends Controller
{
    public function __construct(
        public System $system
    ) {
        //
    }

    public function __invoke(): JsonResponse
    {
        if (! config('pulse.enabled')) {
            return response()->json([
                'success' => false,
                'message' => __('Pulse has been disabled through the Pulse configuration'),
            ]);
        }

        if ($this->system->getSystems()->where('running', '=', true)->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => __('There are no running Pulse instances'),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Ok',
        ]);
    }
}
