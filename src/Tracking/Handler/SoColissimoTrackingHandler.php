<?php

declare(strict_types=1);

namespace App\Tracking\Handler;

use App\Customer\CustomerResolver;
use App\Enum\CarrierEnum;
use App\Notification\NotificationSenderInterface;
use App\Tracking\Sdk\SoColissimo\SoColissimoTrackingProvider;

final class SoColissimoTrackingHandler extends AbstractTrackingHandler
{
    public function __construct(
        public readonly CustomerResolver            $customerResolver,
        public readonly NotificationSenderInterface $notificationSender,
        public readonly SoColissimoTrackingProvider $provider
    )
    {
        parent::__construct($customerResolver, $notificationSender);
    }

    public function supports(string $trackingCode): bool
    {
        return str_starts_with($trackingCode, sprintf('%s-', CarrierEnum::SoColissimo->value));
    }
}
