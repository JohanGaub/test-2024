<?php

declare(strict_types=1);

namespace App\Tracking\Sdk;

use App\Enum\CarrierEnum;
use App\Enum\TrackingStatusEnumInterface;
use App\Tracking\Handler\Domain\TrackingFailureException;

abstract class AbstractTrackingProvider implements TrackingProviderInterface
{
    protected array $parcels = [];

    abstract public function getCarrierEnum(): CarrierEnum;
    abstract public function getTrackingStatusEnum(int $trackingStatusValue): TrackingStatusEnumInterface;

    final public function supports(string $trackingCode): bool
    {
        return str_starts_with($trackingCode, sprintf('%s-', $this->getCarrierEnum()->value));
    }

    final public function provide(string $trackingCode): TrackingResponseInterface
    {
        foreach ($this->parcels as $parcelCode => $parcelStatus) {
            if ($parcelCode === $trackingCode) {
                return new TrackingResponse(
                    $trackingCode,
                    $this->getTrackingStatusEnum($parcelStatus),
                    CarrierEnum::getCarrierLabel($this->getCarrierEnum()),
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
                $this->getCarrierEnum()->name,
                $trackingCode
            )
        );
    }
}
