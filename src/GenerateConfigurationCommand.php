<?php

namespace Neon\ServiceManager;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * @internal
 */
class GenerateConfigurationCommand extends Command
{
    protected $signature = 'neon:service-manager:install';

    protected $description = 'Generate service manager configuration';

    public function handle(): void
    {
        $this->info('Installing Service Manager...');

        $this->info('Publishing configuration...');

        if (!File::exists(config_path('neon-service-manager.php'))) {
            $this->publishConfiguration();
            $this->info('Published configuration');
        } else {
            if ($this->shouldOverwriteConfig()) {
                $this->info('Overwriting configuration file...');
                $this->publishConfiguration(true);
            } else {
                $this->info('Existing configuration was not overwritten');
            }
        }

        $this->info('Installed Service Manager');
    }

    private function shouldOverwriteConfig(): bool
    {
        return $this->confirm(
            'Config file already exists. Do you want to overwrite it?',
            false
        );
    }

    private function publishConfiguration($forcePublish = false): void
    {
        $params = [
            '--provider' => ServiceProvider::class,
            '--tag' => "config"
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }

        $this->call('vendor:publish', $params);
    }
}