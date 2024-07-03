<?php

namespace App\Customer\Domain;

readonly class Customer
{

    public function __construct(
        public string $name,
        public string $email
    ) { }
}
