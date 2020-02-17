<?php

namespace Elbgoods\TrashmailRule\Tests;

use Astrotomic\LaravelGuzzle\LaravelGuzzleServiceProvider;
use Elbgoods\TrashmailRule\TrashmailRuleServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelGuzzleServiceProvider::class,
            TrashmailRuleServiceProvider::class,
        ];
    }
}
