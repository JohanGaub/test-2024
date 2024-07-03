<?php

namespace App\Tracking;

use App\Tracking\Domain\NoMatchingHandlerException;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

final class TrackingManager
{
    private array $handlers;

    public function __construct(#[TaggedIterator('app.tracking_handler')] iterable $handlers)
    {
        $this->handlers = iterator_to_array($handlers);
    }

    /**
     * @param string $trackingCode the parcel tracking code.
     *
     * @throws NoMatchingHandlerException when there is no handler that matched with given tracking code.
     */
    public function track(string $trackingCode): void
    {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($trackingCode)) {
                $handler->handle($trackingCode);

                return;
            }
        }

        throw new NoMatchingHandlerException($trackingCode);
    }
}
