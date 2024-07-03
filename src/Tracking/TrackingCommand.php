<?php

namespace App\Tracking;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'parcel:tracking')]
final class TrackingCommand extends Command
{
    public function __construct(
        private readonly TrackingManager $trackingManager
    ) {
        parent::__construct();
    }

    #[\Override]
    protected function configure(): void
    {
        $this->addArgument('trackingCode', InputArgument::REQUIRED, 'The tracking code');
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $trackingCode = $input->getArgument('trackingCode');

        if (null === $trackingCode) {
            throw new \InvalidArgumentException('Cannot proceed without valid "trackingCode".');
        }

        $this->trackingManager->track($trackingCode);

        return Command::SUCCESS;
    }
}
