<?php

namespace App\Tracking\Sdk\SoColissimo;

use App\Enum\CarrierEnum;
use App\Enum\SoColissimoTrackingStatusEnum;
use App\Enum\TrackingStatusEnumInterface;
use App\Tracking\Handler\Domain\TrackingFailureException;
use App\Tracking\Sdk\AbstractTrackingProvider;
use App\Tracking\Sdk\AddressResponse;
use App\Tracking\Sdk\TrackingProviderInterface;
use App\Tracking\Sdk\TrackingResponse;
use App\Tracking\Sdk\TrackingResponseInterface;

final class SoColissimoTrackingProvider extends AbstractTrackingProvider implements TrackingProviderInterface
{
//    public function supports(string $trackingCode): bool
//    {
//        return str_starts_with($trackingCode, sprintf('%s-', CarrierEnum::SoColissimo->value));
//    }
//
//    public function provide(string $trackingCode): TrackingResponseInterface
//    {
//        $parcels = [
//            'SOCO-D123456789' => SoColissimoTrackingStatusEnum::Delivered,
//            'SOCO-123456789'  => SoColissimoTrackingStatusEnum::Sent,
//            'SOCO-L123456789' => SoColissimoTrackingStatusEnum::Lost
//        ];
//
//        foreach ($parcels as $parcelCode => $parcelStatus) {
//            if ($parcelCode === $trackingCode) {
//                return new TrackingResponse(
//                    $trackingCode,
//                    $parcelStatus,
//                    CarrierEnum::getCarrierLabel(CarrierEnum::SoColissimo),
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
//                CarrierEnum::SoColissimo->name,
//                $trackingCode
//            )
//        );
//    }

    protected array $parcels = [
        'SOCO-D123456789' => SoColissimoTrackingStatusEnum::Delivered,
        'SOCO-123456789'  => SoColissimoTrackingStatusEnum::Sent,
        'SOCO-L123456789' => SoColissimoTrackingStatusEnum::Lost
    ];

    public function getTrackingStatusEnum(mixed $trackingStatusValue): TrackingStatusEnumInterface
    {
        assert($trackingStatusValue instanceof TrackingStatusEnumInterface, new \InvalidArgumentException('Expected TrackingStatusEnumInterface.'));
        return $trackingStatusValue;
    }

    public function getCarrierEnum(): CarrierEnum
    {
        return CarrierEnum::SoColissimo;
    }
}
