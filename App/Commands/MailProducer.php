<?php
namespace App\Commands;
use App\Queues\MailQueue;
use PHPQueueManager\PHPQueueManager\Queue\Message;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use \Symfony\Component\Console\Command\Command;

class MailProducer extends Command
{

    protected static $defaultName = "produce:mail";

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $queue = new MailQueue();

        $message = new Message();

        for ($i = 0; $i < 100; ++$i) {
            $message->setPayload([
                'to_mail'       => 'example' . $i . '@example.com',
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
