<?php

declare(strict_types=1);

namespace Neon\ServiceManager;

use Neon\ServiceManager\Exceptions\ImplementationNotFound;

/**
 * @internal
 */
class ServiceManager
{
    private ?string $version;

    private ?string $client_id;

    private array $default_implementations;

    private array $version_implementations;

    private array $client_implementations;

    public static function getInterfaces(): array
    {
        return config('neon-service-manager.interfaces', []);
    }

    public static function getVersionSlugKey(): string
    {
        return config('neon-service-manager.version_slug_key', 'version');
    }

    public static function getClientSlugKey(): string
    {
        return config('neon-service-manager.client_slug_key', 'client_id');
    }

    public static function create(?string $version, ?string $client_id): static
    {
        return new self($version, $client_id);
    }

    protected function __construct(?string $version, ?string $client_id)
    {
        $this->version = $version;
        $this->client_id = $client_id;

        $this->loadConfig();
    }

    /**
     * @throws ImplementationNotFound
     */
    public function getImplementation(string $interface): string
    {
        return match (true) {
            $this->hasClientImplementation($interface) => $this->getClientImplementation($interface),
            $this->hasVersionImplementation($interface) => $this->getVersionImplementation($interface),
            $this->hasDefaultImplementation($interface) => $this->getDefaultImplementation($interface),
            default => ImplementationNotFound::throw($interface),
        };
    }

    protected function loadConfig(): void
    {
        $this->default_implementations = config('neon-service-manager.default', []);
        $this->version_implementations = config('neon-service-manager.versions', []);
        $this->client_implementations = config('neon-service-manager.clients', []);
    }

    protected function hasClientImplementation(string $interface): bool
    {
        return isset($this->client_implementations[$this->version][$this->client_id][$interface]);
    }

    protected function hasVersionImplementation(string $interface): bool
    {
        return isset($this->version_implementations[$this->version][$interface]);
    }

    protected function hasDefaultImplementation(string $interface): bool
    {
        return isset($this->default_implementations[$interface]);
    }

    protected function getClientImplementation(string $interface): string
    {
        return $this->client_implementations[$this->version][$this->client_id][$interface];
    }

    protected function getVersionImplementation(string $interface): string
    {
        return $this->version_implementations[$this->version][$interface];
    }

    protected function getDefaultImplementation(string $interface): string
    {
        return $this->default_implementations[$interface];
    }
}