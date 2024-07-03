<?php

declare(strict_types=1);

namespace App\Service;

class TrackingStatusService
{
    public function getTrackingStatus(string $trackingCode): string
    {
        $codeAfterDash = substr($trackingCode, strpos($trackingCode, "-") + 1);

        return match(true) {
            str_starts_with($codeAfterDash, 'D') => 'delivered',
            str_starts_with($codeAfterDash, 'P') => 'pending',
            default => 'sent',
        };
    }
}
