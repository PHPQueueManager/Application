<?php
namespace App\Commands\Payments;
use App\Queues\PaymentQueue;
use PHPQueueManager\PHPQueueManager\Queue\MessageInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PaymentConsumer extends Command
{

    protected static $defaultName = "consume:payment";

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $queue = new PaymentQueue();

        $queue->consume(function (MessageInterface $message) {
            try {
                $payload = $message->getPayload();

                return credit_card_payment($payload['credit_card_number'],
                    $payload['credit_card_holder_name'],
                    $payload['credit_card_expiry'],
                    $payload['credit_card_cvv'], $payload['amount']);

            } catch (\Throwable $e) {
                return false;
            }
        });

        return Command::SUCCESS;
    }

    public function configure(): void
    {
        $this->setDescription("");
    }

}
