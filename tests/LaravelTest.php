<?php

namespace Gregoriohc\Moneta\Tests;

use Gregoriohc\Moneta\Laravel\Facade;
use Gregoriohc\Moneta\Laravel\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Config\Repository;
use Mockery;

class LaravelTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Mockery\Mock|Application
     */
    protected $application_mock;

    /**
     * @var ServiceProvider
     */
    protected $service_provider;

    protected function setUp()
    {
        $this->setUpMocks();

        $this->service_provider = new ServiceProvider($this->application_mock);

        parent::setUp();
    }

    protected function setUpMocks()
    {
        $this->application_mock = Mockery::mock('Application, ArrayAccess');
    }

    /**
     * @test
     */
    public function can_get_facade_accessor()
    {
        $this->assertNull(Facade::getFacadeRoot());
    }

    /**
     * @test
     */
    public function service_provider_performs_a_boot_method()
    {
        $this->application_mock->shouldReceive('make')
            ->once()
            ->withAnyArgs()
            ->andReturn('');

        $this->application_mock->shouldReceive('publishes')
            ->once()
            ->with([
                __DIR__.'/../../config/moneta.php' => '/moneta.php',
            ])
            ->andReturnNull();

        $this->application_mock->shouldReceive('mergeConfigFrom')
            ->once()
            ->withArgs([
                __DIR__.'/../../config/moneta.php',
                'moneta',
            ])
            ->andReturnNull();

        $this->application_mock->shouldReceive('afterResolving')
            ->once()
            ->withAnyArgs()
            ->andReturn('');

        $this->assertNull($this->service_provider->boot());
    }

    /**
     * @test
     */
    public function service_provider_performs_a_register_method()
    {
        $configMock = Mockery::mock(Repository::class);

        $this->application_mock->shouldReceive('offsetGet')
            ->once()
            ->withAnyArgs()
            ->andReturn($configMock);

        $configMock->shouldReceive('get')
            ->once()
            ->withAnyArgs()
            ->andReturn([]);

        $configMock->shouldReceive('set')
            ->once()
            ->withAnyArgs()
            ->andReturnNull();

        $this->application_mock->shouldReceive('share')
            ->once()
            ->withAnyArgs()
            ->andReturn(function(){});

        $this->application_mock->shouldReceive('offsetSet')
            ->once()
            ->withAnyArgs()
            ->andReturnNull();

        $this->assertNull($this->service_provider->register());
    }
}