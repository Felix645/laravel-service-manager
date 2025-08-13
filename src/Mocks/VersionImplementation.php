<?php

namespace Neon\ServiceManager\Mocks;

/**
 * @internal
 */
class VersionImplementation implements TestInterface
{

    public function test(): string
    {
        return 'version';
    }
}