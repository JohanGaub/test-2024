<?php

declare(strict_types=1);

namespace App\Tracking\Handler;

use App\Customer\CustomerResolver;
use App\Notification\Domain\Notification;
use App\Notification\NotificationSenderInterface;
use App\Tracking\Sdk\NoMatchingProviderException;

abstract class AbstractTrackingHandler implements TrackingHandlerInterface
{
    public function __construct(
        private readonly CustomerResolver   $customerResolver,
        private readonly NotificationSenderInterface $notificationSender
    )
    {
    }

    final public function handle(string $trackingCode): void
    {
        if ($this->provider->supports($trackingCode)) {
            // 1) Récupérer la réponse du trackingProvider : code/statut/adresse + nom du transporteur
            $trackingResponse = $this->provider->provide($trackingCode);

            // 2) Récupérer l’utilisateur
            $customer = $this->customerResolver->resolveByParcelTrackingId($trackingCode);

            // 3) Créer la notification
            $notification = new Notification(
                sprintf(
                    'New %s parcel "%s" %s.',
                    $trackingResponse->carrierLabel,
                    $trackingCode,
                    strtolower($trackingResponse->statusEnum->name),
                ));

            // 4) Envoyer la notification UNIQUEMENT si le statut est "delivered"
            if ($trackingResponse->statusEnum->isDelivered()) {
                $this->notificationSender->send($notification, $customer);
            }

            return;
        }

        throw new NoMatchingProviderException($trackingCode);
    }
}
