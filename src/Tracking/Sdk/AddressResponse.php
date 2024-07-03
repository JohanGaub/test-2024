<?php

namespace App\Tracking\Sdk;

final readonly class AddressResponse
{
    public function __construct(
        public string $address,
        public string $zipCode,
        public string $city,
        public string $countryCode
    )
    {
    }
}
