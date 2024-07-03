<?php

namespace App\Tracking\Sdk\Chronopost;

use App\Enum\CarrierEnum;
use App\Enum\ChronopostTrackingStatusEnum;
use App\Enum\TrackingStatusEnumInterface;
use App\Tracking\Handler\Domain\TrackingFailureException;
use App\Tracking\Sdk\AbstractTrackingProvider;
use App\Tracking\Sdk\AddressResponse;
use App\Tracking\Sdk\TrackingProviderInterface;
use App\Tracking\Sdk\TrackingResponse;
use App\Tracking\Sdk\TrackingResponseInterface;

final class ChronopostTrackingProvider extends AbstractTrackingProvider implements TrackingProviderInterface
{
//    public function supports(string $trackingCode): bool
//    {
//        return str_starts_with($trackingCode, sprintf('%s-', CarrierEnum::Chronopost->value));
//    }

//    public function provide(string $trackingCode): TrackingResponseInterface
//    {
//        $parcels = [
//            'CP-123456789'  => ChronopostTrackingStatusEnum::Sent,
//            'CP-D123456789' => ChronopostTrackingStatusEnum::Delivered
//        ];
//
//        foreach ($parcels as $parcelCode => $parcelStatus) {
//            if ($parcelCode === $trackingCode) {
//                return new TrackingResponse(
//                    $trackingCode,
//                    $parcelStatus,
//                    CarrierEnum::getCarrierLabel(CarrierEnum::Chronopost),
//                    new AddressResponse(
//                        '78 rue Professeur Rochaix',
//                        '69003',
//                        'Lyon',
//                        'FR'
//                    )
//                );
//            }
//        }
//
//        throw new TrackingFailureException(
//            sprintf(
//                'Could not find %s parcel tracking with ID "%s".',
//                CarrierEnum::Chronopost->name,
//                $trackingCode
//            )
//        );
//    }

    protected array $parcels = [
        'CP-123456789'  => ChronopostTrackingStatusEnum::Sent,
        'CP-D123456789' => ChronopostTrackingStatusEnum::Delivered
    ];

    public function getTrackingStatusEnum(mixed $trackingStatusValue): TrackingStatusEnumInterface
    {
        assert($trackingStatusValue instanceof TrackingStatusEnumInterface, new \InvalidArgumentException('Expected TrackingStatusEnumInterface.'));
        return $trackingStatusValue;
    }

    public function getCarrierEnum(): CarrierEnum
    {
        return CarrierEnum::Chronopost;
    }
}
