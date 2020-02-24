<?php

namespace Elbgoods\TrashmailRule\Tests;

use Astrotomic\LaravelGuzzle\GuzzleServiceProvider;
use Elbgoods\TrashmailRule\TrashmailRuleServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            GuzzleServiceProvider::class,
            TrashmailRuleServiceProvider::class,
        ];
    }
}
