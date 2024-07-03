<?php

namespace App\Notification;

use App\Customer\Domain\Customer;
use App\Notification\Domain\Notification;
use App\Notification\Domain\NotificationFailureException;

interface NotificationSenderInterface
{
    /**
     * Sends some mail notification to the {@see Customer}.
     *
     * @param Notification $notification the notification to send to the customer.
     * @param Customer $recipient the customer to be notified.
     *
     * @throws NotificationFailureException when notification could not be sent.
     */
    public function send(Notification $notification, Customer $recipient): void;
}
