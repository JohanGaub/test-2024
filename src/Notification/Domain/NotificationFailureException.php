<?php

namespace App\Notification\Domain;

use App\Customer\Domain\Customer;

final class NotificationFailureException extends \RuntimeException
{
    public function __construct(Customer $recipient)
    {
        parent::__construct(
            sprintf('Unable to send notification to customer with email "%s".', $recipient->email)
        );
    }
}
