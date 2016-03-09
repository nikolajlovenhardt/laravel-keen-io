<?php

namespace LaravelKeenIOTest\Facades;

use LaravelKeenIO\Facades\KeenIOFacade;
use LaravelKeenIO\Services\KeenIOService;
use PHPUnit_Framework_TestCase;

class LaravelKeenIOTestTest extends PHPUnit_Framework_TestCase
{
    /** @var KeenIOFacade */
    protected $facade;

    public function setUp()
    {
        $facade = new KeenIOFacade();
        $this->facade = $facade;
    }

    public function testGetFacadeAccessor()
    {
        $method = self::getMethod('getFacadeAccessor');
        $object = clone $this->facade;

        $result = $method->invoke($object);

        $this->assertSame(KeenIOService::class, $result);
    }

    /**
     * Test protected method
     *
     * @param string $name
     * @return \ReflectionMethod
     */
    protected static function getMethod($name)
    {
        $class = new \ReflectionClass(KeenIOFacade::class);

        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }
}
