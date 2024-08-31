<?php
namespace App\Commands\SMS;
use App\Messages\SMSMessage;
use App\Queues\NotificationQueue;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SMSProducer extends Command
{

    protected static $defaultName = "produce:sms";

    public function execute(InputInterface $input, OutputInterface $output): int
    {

        $queue = new NotificationQueue();

        $message = new SMSMessage();

        for ($i = 10; $i < 100; ++$i) {
            $message->setPayload([
                'phone_number'      => '+9011111111' . $i
            ]);

            $queue->publish($message);
        }

        return Command::SUCCESS;
    }

    public function configure(): void
    {
        $this->setDescription("");
    }

}
