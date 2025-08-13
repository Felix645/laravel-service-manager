<?php

namespace Neon\ServiceManager\Mocks;

/**
 * @internal
 */
class ClientImplementation implements TestInterface
{

    public function test(): string
    {
        return 'client';
    }
}