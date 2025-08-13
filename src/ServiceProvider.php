<?php

declare(strict_types=1);

namespace Neon\ServiceManager;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * @internal
 */
class ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishConfig();
            $this->registerCommands();
        }

        $this->bindInterfaces();
    }

    protected function registerConfig(): void
    {
        if ($this->isNeonTest()) {
            $config_file = '/../config/config_test.php';
        } else {
            $config_file = '/../config/config.php';
        }

        $this->mergeConfigFrom(__DIR__ . $config_file, 'neon-service-manager');
    }

    protected function publishConfig(): void
    {
        if ($this->isNeonTest()) {
            $config_file = '/../config/config_test.php';
        } else {
            $config_file = '/../config/config.php';
        }

        $this->publishes([
            __DIR__ . $config_file => config_path('neon-service-manager.php'),
        ], 'config');
    }

    protected function registerCommands(): void
    {
        $this->commands([
            GenerateConfigurationCommand::class,
        ]);
    }

    protected function bindInterfaces(): void
    {
        $interfaces = ServiceManager::getInterfaces();

        if (empty($interfaces)) {
            return;
        }

        $binding_function = function($app, $interface) {
            $client_slug_key = ServiceManager::getClientSlugKey();
            $version_slug_key = ServiceManager::getVersionSlugKey();

            $client_id = $app->request->route()->parameter($client_slug_key);
            $version = $app->request->route()->parameter($version_slug_key);

            $implementation = ServiceManager::create($version, $client_id)->getImplementation($interface);

            return app($implementation);
        };

        foreach ($interfaces as $interface) {
            $this->app->bind($interface, function ($app) use ($binding_function, $interface) {
                return $binding_function($app, $interface);
            });
        }
    }

    protected function isNeonTest(): bool
    {
        return $this->app->environment() === 'testing' && env('NEON_SERV_MANAGER_TEST_CONFIG', false);
    }
}