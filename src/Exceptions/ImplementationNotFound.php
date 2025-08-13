<?php

namespace Neon\ServiceManager\Exceptions;

use Exception;

/**
 * @internal
 */
class ImplementationNotFound extends Exception
{
    public static function throw(string $interface): void
    {
        $message = "No Implementation for '$interface' found";

        throw new static($message, 500);
    }
}