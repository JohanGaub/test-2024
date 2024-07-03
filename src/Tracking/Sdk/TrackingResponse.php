<?php

namespace App\Tracking\Sdk;

use App\Enum\TrackingStatusEnumInterface;

final readonly class TrackingResponse implements TrackingResponseInterface
{
    public function __construct(
        public string                      $trackingCode,
        public TrackingStatusEnumInterface $statusEnum,
        public string                      $carrierLabel,
        public AddressResponse             $addressResponse,
        public \DateTimeInterface          $updatedAt = new \DateTimeImmutable()
    )
    {
    }
}
