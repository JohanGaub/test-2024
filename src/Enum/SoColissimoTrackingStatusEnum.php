<?php

namespace App\Enum;

enum SoColissimoTrackingStatusEnum: string implements TrackingStatusEnumInterface
{
    case Sent = 'sent';
    case Delivered = 'delivered';
    case Lost = 'lost';

    public function isDelivered(): bool
    {
        return $this === self::Delivered;
    }
}
