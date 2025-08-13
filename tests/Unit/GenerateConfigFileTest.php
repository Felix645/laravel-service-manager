<?php

namespace Neon\ServiceManager\Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Neon\ServiceManager\Tests\TestCase;

/**
 * @internal
 */
class GenerateConfigFileTest extends TestCase
{
    public function test_config_command_generates_config_file(): void
    {
        if (File::exists(config_path('neon-service-manager.php'))) {
            unlink(config_path('neon-service-manager.php'));
        }

        $this->assertFalse(File::exists(config_path('neon-service-manager.php')));

        Artisan::call('neon:service-manager:install');

        $this->assertTrue(File::exists(config_path('neon-service-manager.php')));
    }
}