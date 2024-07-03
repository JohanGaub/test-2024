<?php

namespace App\Tracking\Sdk;

final class NoMatchingProviderException extends \RuntimeException
{
    public function __construct(string $trackingCode)
    {
        parent::__construct(
            sprintf('Could not match provider service for tracking code "%s".', $trackingCode)
        );
    }
}
