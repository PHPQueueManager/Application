<?php
namespace App\Commands;

use App\Queues\MailQueue;
use PHPQueueManager\PHPQueueManager\Queue\MessageInterface;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use \Symfony\Component\Console\Command\Command;

class MailConsumer extends Command
{

    protected static $defaultName = "consume:mail";

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $queue = new MailQueue();

        $queue->consume(function (MessageInterface $message) {
            $payload = $message->getPayload();
            if (filter_var($payload['to_mail'], FILTER_VALIDATE_EMAIL)) {
                sleep(2);

                return true;
            }

            return false;
        });

        return Command::SUCCESS;
    }

    public function configure(): void
    {
        $this->setDescription("Sends the emails in the queue.");
    }

}
