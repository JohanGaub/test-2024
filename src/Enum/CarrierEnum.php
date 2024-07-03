<?php

declare(strict_types=1);

namespace App\Enum;

enum CarrierEnum: string implements CarrierEnumInterface
{
    case MondialRelay = "MR";
    case SoColissimo = "SOCO";
    case Chronopost = "CP";

    public static function getCarrierLabel(self $carrier): string
    {
        return match($carrier) {
            self::MondialRelay => "Mondial Relay",
            self::SoColissimo => "SoColissimo",
            self::Chronopost => "Chronopost",
        };
    }
}
