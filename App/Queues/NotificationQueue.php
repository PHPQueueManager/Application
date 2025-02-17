<?php

namespace App\Queues;

use PHPQueueManager\PHPQueueManager\Adapters\AdapterFactory;
use PHPQueueManager\PHPQueueManager\Queue\Queue;

class NotificationQueue extends Queue
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
        return 'notification_queue';
    }

    public function getDLQName(): string
    {
        return 'notification_queue_dead_letter_queue';
    }

}
