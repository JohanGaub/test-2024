<?php

namespace App\Tracking\Sdk\SoColissimo\Dto;

use App\Enum\TrackingStatusEnumInterface;
use App\Tracking\Sdk\AddressResponse;
use App\Tracking\Sdk\TrackingResponseInterface;

final readonly class SoColissimoTrackingResponse implements TrackingResponseInterface
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
