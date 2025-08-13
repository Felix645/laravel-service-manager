<?php

namespace Neon\ServiceManager\Mocks;

/**
 * @internal
 */
class DefaultImplementation implements TestInterface
{
    public function test(): string
    {
        return 'default';
    }
}