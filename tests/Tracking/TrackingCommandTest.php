<?php

namespace Tests\Tracking;

use App\Customer\Domain\Customer;
use App\Notification\Domain\Notification;
use App\Notification\NotificationSenderInterface;
use App\Tracking\Domain\NoMatchingHandlerException;
use App\Tracking\Handler\Domain\TrackingFailureException;
use App\Tracking\TrackingCommand;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

final class TrackingCommandTest extends KernelTestCase
{
    #[DataProvider('deliveredParcels')]
    public function testThatDeliveredParcelsAreNotifiedToTheCustomer(string $trackingCode, string $message, Customer $recipient): void
    {
        // setup environment
        self::bootKernel();
        $container = self::getContainer();
        $application = new Application(self::$kernel);

        // Mock
        $notificationSenderMock = $this->createMock(NotificationSenderInterface::class);
        $notificationSenderMock
            ->expects($this->once())
            ->method('send')
            ->with(new Notification($message), $recipient);
        $container->set(NotificationSenderInterface::class, $notificationSenderMock);

        // execute command
        $command = $application->find(TrackingCommand::getDefaultName());
        $tester = new CommandTester($command);
        $tester->execute(['trackingCode' => $trackingCode]);

        // assertions
        $tester->assertCommandIsSuccessful();
    }

    #[DataProvider('notDeliveredParcels')]
    public function testThatNotDeliveredParcelsAreNotNotifiedToTheCustomer(string $trackingCode): void
    {
        // setup environment
        self::bootKernel();
        $container = self::getContainer();
        $application = new Application(self::$kernel);

        // Mock
        $notificationSenderMock = $this->createMock(NotificationSenderInterface::class);
        $notificationSenderMock
            ->expects($this->never())
            ->method('send');
        $container->set(NotificationSenderInterface::class, $notificationSenderMock);

        // execute command
        $command = $application->find(TrackingCommand::getDefaultName());
        $tester = new CommandTester($command);
        $tester->execute(['trackingCode' => $trackingCode]);

        // assertions
        $tester->assertCommandIsSuccessful();
    }

    public function testUnrecognizedTrackingCodeFormat(): void
    {
        // setup environment
        self::bootKernel();
        $application = new Application(self::$kernel);

        // execute command
        $command = $application->find(TrackingCommand::getDefaultName());
        $tester = new CommandTester($command);

        $this->expectException(NoMatchingHandlerException::class);
        $tester->execute(['trackingCode' => '0987656789']);
    }

    public function testTrackingCodeNotExists(): void
    {
        // setup environment
        self::bootKernel();
        $application = new Application(self::$kernel);

        // execute command
        $command = $application->find(TrackingCommand::getDefaultName());
        $tester = new CommandTester($command);

        $this->expectException(TrackingFailureException::class);
        $tester->execute(['trackingCode' => 'MR-VCJKGHJKJH']);
    }

    public static function deliveredParcels(): array
    {
        return [
            [
                'SOCO-D123456789',
                'New SoColissimo parcel "SOCO-D123456789" delivered.',
                new Customer('John Wayne', 'j.wayne@soco.com')
            ],
            [
                'MR-D123456789',
                'New Mondial Relay parcel "MR-D123456789" delivered.',
                new Customer('John Doe', 'j.doe@mondialrelay.com')
            ],
            [
                'CP-D123456789',
                'New Chronopost parcel "CP-D123456789" delivered.',
                new Customer('Jack Sparrow', 'j.sparrow@chronopost.com')
            ]
        ];
    }

    public static function notDeliveredParcels(): array
    {
        return [['SOCO-123456789'], ['MR-123456789'], ['CP-123456789']];
    }
}
