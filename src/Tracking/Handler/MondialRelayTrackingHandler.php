<?php

declare(strict_types=1);

namespace App\Tracking\Handler;

use App\Customer\CustomerResolver;
use App\Enum\CarrierEnum;
use App\Notification\NotificationSenderInterface;
use App\Tracking\Sdk\MondialRelay\MondialRelayTrackingProvider;

final class MondialRelayTrackingHandler extends AbstractTrackingHandler
{
    public function __construct(
        public readonly CustomerResolver            $customerResolver,
        public readonly NotificationSenderInterface $notificationSender,
        public readonly MondialRelayTrackingProvider $provider
    )
    {
        parent::__construct($customerResolver, $notificationSender);
    }

    public function supports(string $trackingCode): bool
    {
        return str_starts_with($trackingCode, sprintf('%s-', CarrierEnum::MondialRelay->value));
    }
}
