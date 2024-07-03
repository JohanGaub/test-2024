<?php

namespace App\Tracking\Domain;

final class NoMatchingHandlerException extends \RuntimeException
{
    public function __construct(string $trackingCode)
    {
        parent::__construct(
            sprintf('Could not match any postal service handler for tracking code "%s".', $trackingCode)
        );
    }
}
