<?php

declare(strict_types=1);

namespace App\Tracking\Handler;

use App\Enum\CarrierEnum;

final class SoColissimoTrackingHandler extends AbstractTrackingHandler
{
    public function supports(string $trackingCode): bool
    {
        return str_starts_with($trackingCode, sprintf('%s-', CarrierEnum::SoColissimo->value));
    }
}
