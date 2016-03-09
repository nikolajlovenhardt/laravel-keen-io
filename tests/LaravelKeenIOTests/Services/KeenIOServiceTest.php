<?php

namespace LaravelKeenIOTest\Services;

use KeenIO\Client\KeenIOClient;
use LaravelKeenIO\Exceptions\ConfigurationException;
use LaravelKeenIO\Options\ModuleOptions;
use LaravelKeenIO\Services\KeenIOService;
use PHPUnit_Framework_TestCase;

class KeenIOServiceTest extends PHPUnit_Framework_TestCase
{
    /** @var KeenIOService */
    protected $service;

    /** @var ModuleOptions */
    protected $moduleOptions;

    public function setUp()
    {
        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $this->getMockBuilder(ModuleOptions::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->moduleOptions = $moduleOptions;

        $this->service = new KeenIOService($moduleOptions);
    }

    public function testClientUseDefaultNoConfiguration()
    {
        $project = 'defaultName';

        $projects = [
            'invalidName' => [
                'projectId' => 'projectId',
                'masterKey' => 'masterKey',
                'readKey' => 'readKey',
                'writeKey' => 'writeKey',
                'version' => 'version',
            ],
        ];

        $this->moduleOptions->expects($this->at(0))
            ->method('get')
            ->with('default')
            ->willReturn($project);

        $this->moduleOptions->expects($this->at(1))
            ->method('get')
            ->with('projects')
            ->willReturn($projects);

        $this->setExpectedException(
            ConfigurationException::class,
            sprintf(
                'No configuration found for \'%s\'',
                $project
            )
        );

        $this->service->client();
    }

    public function testClientUseDefaultNoVersion()
    {
        $project = 'defaultName';
        $version  = null;

        $projects = [
            'defaultName' => [
                'projectId' => 'projectId',
                'masterKey' => 'masterKey',
                'readKey' => 'readKey',
                'writeKey' => 'writeKey',
                'version' => $version,
            ],
        ];

        $this->moduleOptions->expects($this->at(0))
            ->method('get')
            ->with('default')
            ->willReturn($project);

        $this->moduleOptions->expects($this->at(1))
            ->method('get')
            ->with('projects')
            ->willReturn($projects);

        /** @var KeenIOClient $result */
        $result = $this->service->client();

        $this->assertInstanceOf(
            KeenIOClient::class,
            $result
        );

        $this->assertSame(
            $projects[$project]['projectId'],
            $result->getProjectId()
        );

        $this->assertSame(
            $projects[$project]['masterKey'],
            $result->getMasterKey()
        );

        $this->assertSame(
            $projects[$project]['readKey'],
            $result->getReadKey()
        );

        $this->assertSame(
            $projects[$project]['writeKey'],
            $result->getWriteKey()
        );

        $this->assertSame(
            KeenIOService::DEFAULT_VERSION,
            $result->getVersion()
        );
    }

    public function testClientUseDefault()
    {
        $project = 'defaultName';
        $version  = '3.0';

        $projects = [
            'defaultName' => [
                'projectId' => 'projectId',
                'masterKey' => 'masterKey',
                'readKey' => 'readKey',
                'writeKey' => 'writeKey',
                'version' => $version,
            ],
        ];

        $this->moduleOptions->expects($this->at(0))
            ->method('get')
            ->with('default')
            ->willReturn($project);

        $this->moduleOptions->expects($this->at(1))
            ->method('get')
            ->with('projects')
            ->willReturn($projects);

        /** @var KeenIOClient $result */
        $result = $this->service->client();

        $this->assertInstanceOf(
            KeenIOClient::class,
            $result
        );

        $this->assertSame(
            $projects[$project]['projectId'],
            $result->getProjectId()
        );

        $this->assertSame(
            $projects[$project]['masterKey'],
            $result->getMasterKey()
        );

        $this->assertSame(
            $projects[$project]['readKey'],
            $result->getReadKey()
        );

        $this->assertSame(
            $projects[$project]['writeKey'],
            $result->getWriteKey()
        );

        $this->assertSame(
            KeenIOService::DEFAULT_VERSION,
            $result->getVersion()
        );
    }
}