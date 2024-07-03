<?php

namespace App\Tracking\Sdk\Chronopost;

use App\Enum\CarrierEnum;
use App\Enum\ChronopostTrackingStatusEnum;
use App\Tracking\Handler\Domain\TrackingFailureException;
use App\Tracking\Sdk\AddressResponse;
use App\Tracking\Sdk\TrackingProviderInterface;
use App\Tracking\Sdk\TrackingResponse;
use App\Tracking\Sdk\TrackingResponseInterface;

final readonly class ChronopostTrackingProvider implements TrackingProviderInterface
{
    public function supports(string $trackingCode): bool
    {
        return str_starts_with($trackingCode, sprintf('%s-', CarrierEnum::Chronopost->value));
    }

    public function provide(string $trackingCode): TrackingResponseInterface
    {
        $parcels = [
            'CP-123456789'  => ChronopostTrackingStatusEnum::Sent,
            'CP-D123456789' => ChronopostTrackingStatusEnum::Delivered
        ];

        foreach ($parcels as $parcelCode => $parcelStatus) {
            if ($parcelCode === $trackingCode) {
                return new TrackingResponse(
                    $trackingCode,
                    $parcelStatus,
                    CarrierEnum::getCarrierLabel(CarrierEnum::Chronopost),
                    new AddressResponse(
                        '78 rue Professeur Rochaix',
                        '69003',
                        'Lyon',
                        'FR'
                    )
                );
            }
        }

        throw new TrackingFailureException(
            sprintf(
                'Could not find %s parcel tracking with ID "%s".',
                CarrierEnum::Chronopost->name,
                $trackingCode
            )
        );
    }
}
