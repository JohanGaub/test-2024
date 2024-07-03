<?php

namespace App\Tracking\Handler\Domain;

final class TrackingFailureException extends \RuntimeException
{
    public function __construct(string $message, \Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
