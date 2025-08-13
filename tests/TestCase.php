<?php

namespace Neon\ServiceManager\Tests;

use Neon\ServiceManager\ServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

/**
 * @internal
 */
abstract class TestCase extends BaseTestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }

    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class
        ];
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }
}