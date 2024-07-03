<?php

namespace App\Customer;

use App\Customer\Domain\Customer;
use App\Enum\CarrierEnum;

final class CustomerResolver
{
    public function resolveByParcelTrackingId(string $trackingCode): Customer
    {
        $codeBeforeDash = substr($trackingCode, 0, strpos($trackingCode, "-"));

        if ($carrierEnum = CarrierEnum::tryFrom($codeBeforeDash)) {
            return match ($carrierEnum) {
                CarrierEnum::MondialRelay => new Customer('John Doe', 'j.doe@mondialrelay.com'),
                CarrierEnum::SoColissimo => new Customer('John Wayne', 'j.wayne@soco.com'),
                CarrierEnum::Chronopost => new Customer('Jack Sparrow', 'j.sparrow@chronopost.com'),
            };
        }

        return new Customer('Unknown Customer', 'unknowncustomer@sendercompany.com');
    }
}
