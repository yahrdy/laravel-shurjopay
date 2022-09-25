<?php

namespace Yahrdy\Shurjopay\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Yahrdy\Shurjopay\Shurjopay
 */
class Shurjopay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Yahrdy\Shurjopay\Shurjopay::class;
    }
}
