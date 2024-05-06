<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function consecutiveCalls(...$args): callable
    {
        $count = 0;

        return function ($arg) use (&$count, $args) {
            return $arg === $args[$count++];
        };
    }
}
