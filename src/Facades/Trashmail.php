<?php

namespace Elbgoods\TrashmailRule\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isDisposable(string $email)
 */
class Trashmail extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Elbgoods\TrashmailRule\Trashmail::class;
    }
}
