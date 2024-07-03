<?php

declare(strict_types=1);

namespace App\Enum;

enum MondialRelayTrackingStatusEnum: int implements TrackingStatusEnumInterface
{
    case Pending = 1;
    case Sent = 2;
    case Delivered = 3;

    public function isDelivered(): bool
    {
        return $this === self::Delivered;
    }
}
