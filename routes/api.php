<?php

use Illuminate\Support\Facades\Route;
use WebduoNederland\PulseApi\Http\Controllers\ExceptionsController;
use WebduoNederland\PulseApi\Http\Controllers\SlowJobsController;
use WebduoNederland\PulseApi\Http\Controllers\SlowOutgoingRequestsController;
use WebduoNederland\PulseApi\Http\Controllers\SlowQueriesController;
use WebduoNederland\PulseApi\Http\Controllers\SlowRequestsController;
use WebduoNederland\PulseApi\Http\Controllers\StatusController;
use WebduoNederland\PulseApi\Http\Controllers\SystemController;

Route::get('status', StatusController::class);

Route::get('systems', [SystemController::class, 'list']);
Route::get('system/{name}', [SystemController::class, 'index']);

Route::get('slow-requests', SlowRequestsController::class);
Route::get('slow-outgoing-requests', SlowOutgoingRequestsController::class);
Route::get('slow-queries', SlowQueriesController::class);
Route::get('slow-jobs', SlowJobsController::class);

Route::get('exceptions', ExceptionsController::class);
