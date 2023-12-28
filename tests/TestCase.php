<?php

namespace WebduoNederland\PulseApi\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use WebduoNederland\PulseApi\PulseApiServiceProvider;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            PulseApiServiceProvider::class,
        ];
    }
}
