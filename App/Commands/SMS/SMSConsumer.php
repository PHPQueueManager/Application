<?php
namespace App\Commands\SMS;
use App\Queues\NotificationQueue;
use PHPQueueManager\PHPQueueManager\Queue\MessageInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SMSConsumer extends Command
{

    protected static $defaultName = "consume:sms";

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $queue = new NotificationQueue();

        $queue->consume(function (MessageInterface $message) {
            // The workers that will work for NotificationQueue are defined in Message.

            return true;
        });
        return Command::SUCCESS;
    }

    public function configure(): void
    {
        $this->setDescription("");
    }

}
