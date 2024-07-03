<?php

namespace App\Tracking\Sdk\MondialRelay;

use App\Enum\CarrierEnum;
use App\Enum\MondialRelayTrackingStatusEnum;
use App\Enum\TrackingStatusEnumInterface;
use App\Tracking\Handler\Domain\TrackingFailureException;
use App\Tracking\Sdk\AddressResponse;
use App\Tracking\Sdk\TrackingProviderInterface;
use App\Tracking\Sdk\TrackingResponse;
use App\Tracking\Sdk\TrackingResponseInterface;

final readonly class MondialRelayTrackingProvider implements TrackingProviderInterface
{
    public function supports(string $trackingCode): bool
    {
        return str_starts_with($trackingCode, sprintf('%s-', CarrierEnum::MondialRelay->value));
    }

    public function provide(string $trackingCode): TrackingResponseInterface
    {
        $parcels = [
            'MR-123456789'  => 2, // sent
            'MR-D123456789' => 3 // delivered
        ];

        foreach ($parcels as $parcelCode => $parcelStatus) {
            if ($parcelCode === $trackingCode) {
                return new TrackingResponse(
                    $trackingCode,
                    $this->getTrackingStatusEnum($parcelStatus),
                    CarrierEnum::getCarrierLabel(CarrierEnum::MondialRelay),
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
                CarrierEnum::MondialRelay->name,
                $trackingCode
            )
        );
    }

    public function getTrackingStatusEnum(int $trackingStatusValue): TrackingStatusEnumInterface
    {
        return MondialRelayTrackingStatusEnum::from($trackingStatusValue);
    }
}
