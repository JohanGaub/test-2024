<?php

namespace App\Notification\Domain;

final readonly class Notification
{

    public function __construct(
        public string $message
    ) { }

    public function __toString(): string
    {
        return ucfirst($this->message);
    }
}
