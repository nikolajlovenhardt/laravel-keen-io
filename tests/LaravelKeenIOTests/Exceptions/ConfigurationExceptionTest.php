<?php

namespace LaravelUserNotificationsTest\Exceptions;

use LaravelKeenIO\Exceptions\ConfigurationException;
use PHPUnit_Framework_TestCase;

class ConfigurationExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testException()
    {
        $this->setExpectedException(
            ConfigurationException::class,
            'Demo message'
        );

        throw new ConfigurationException('Demo message');
    }
}