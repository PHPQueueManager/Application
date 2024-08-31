<?php

namespace App\Queues;

use PHPQueueManager\PHPQueueManager\Adapters\AdapterFactory;
use PHPQueueManager\PHPQueueManager\Queue\Queue;

class PaymentQueue extends Queue
{

    public function __construct()
    {
        $adapter = AdapterFactory::create('rabbitmq', [
            'host'          => env("RABBITMQ_HOST", "localhost"),
            'port'          => env("RABBITMQ_PORT", 5672),
            'username'      => env("RABBITMQ_USER", "guest"),
            'password'      => env("RABBITMQ_PASS", "guest"),
        ]);

        parent::__construct($adapter);
    }

    public function getName(): string
    {
        return 'payment_queue';
    }

    public function getDLQName(): string
    {
        return 'payment_queue_dead_letter_queue';
    }

}
