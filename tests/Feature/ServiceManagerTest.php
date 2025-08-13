<?php

namespace Feature;

use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Route;
use Neon\ServiceManager\Exceptions\ImplementationNotFound;
use Neon\ServiceManager\Mocks\AnotherInterface;
use Neon\ServiceManager\Mocks\TestInterface;
use Neon\ServiceManager\Tests\TestCase;

/**
 * @internal
 */
class ServiceManagerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Route::get('/{version}/{client_id}/test', function (TestInterface $test) {
            return $test->test();
        });
    }

    public function test_default_implementation(): void
    {
        $response = $this->get('/v1/some_client/test');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('default', $response->getContent());
    }

    public function test_version_implementation(): void
    {
        $response = $this->get('/v2/some_client/test');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('version', $response->getContent());
    }

    public function test_client_implementation(): void
    {
        $response = $this->get('/v3/test_client/test');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('client', $response->getContent());
    }

    public function test_unknown_interface_throws_exception(): void
    {
        Route::get('/{version}/{client_id}/something', function (AnotherInterface $test) {
            return $test->something();
        });

        Exceptions::fake();

        $response = $this->get('/v3/test_client/something');

        Exceptions::assertReported(ImplementationNotFound::class);

        $this->assertEquals(500, $response->getStatusCode());
    }
}