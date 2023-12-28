<?php

namespace WebduoNederland\PulseApi\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use WebduoNederland\PulseApi\Actions\System;

class SystemController extends Controller
{
    public function __construct(
        public System $system
    ) {
        //
    }

    public function index(string $name): JsonResponse
    {
        $system = $this->system->getSystem($name);

        if (is_null($system)) {
            return response()->json([
                'success' => false,
                'message' => __('System not found'),
            ], 404);
        }

        return response()->json($system);
    }

    public function list(): JsonResponse
    {
        $onlyRunning = false;

        if (request()->has('only_running')) {
            $onlyRunning = strtolower(request()->input('only_running'));

            if ($onlyRunning != 'true' && $onlyRunning != 'false') {
                return response()->json([
                    'success' => false,
                    'message' => __('The only_running filter can only be true or false!'),
                ], 400);
            }

            $onlyRunning = ($onlyRunning === 'true');
        }

        $systems = $this->system->getSystems($onlyRunning)
            ->toArray();

        return response()->json($systems);
    }
}
