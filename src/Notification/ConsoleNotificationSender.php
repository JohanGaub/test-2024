<?php

namespace App\Notification;

use App\Customer\Domain\Customer;
use App\Notification\Domain\Notification;
use Psr\Log\LoggerInterface;

readonly class ConsoleNotificationSender implements NotificationSenderInterface
{
    public function __construct(
        private LoggerInterface $logger
    ) { }

    #[\Override]
    public function send(Notification $notification, Customer $recipient): void
    {
        $this->logger->info(sprintf('[%s <%s>] %s', $recipient->name, $recipient->email, $notification));
    }
}
