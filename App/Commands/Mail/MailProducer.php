<?php
namespace App\Commands\Mail;
use App\Messages\MailMessage;
use App\Queues\NotificationQueue;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MailProducer extends Command
{

    protected static $defaultName = "produce:mail";

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $queue = new NotificationQueue();

        $message = new MailMessage();

        for ($i = 0; $i < 100; ++$i) {
            $message->mail('example' . $i . '@example.com', 'Welcome ' . $i, '');

            $queue->publish($message);
        }

        return Command::SUCCESS;
    }

    public function configure(): void
    {
        $this->setDescription("");
    }

}
