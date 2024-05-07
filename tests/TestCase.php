<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function consecutiveCalls(...$args): callable
    {
        $count = 0;

        return function ($arg) use (&$count, $args) {
            return $arg === $args[$count++];
        };
    }

    protected function invokeNonPublicMethod(object $instance, string $methodName, array $methodParams)
    {
        $reflectionClass = new \ReflectionClass(get_class($instance));
        $reflectionMethod = $reflectionClass->getMethod($methodName);
        $reflectionMethod->setAccessible(true);

        //this call the private method being tested
        return $reflectionMethod->invokeArgs($instance, $methodParams);
    }
}
