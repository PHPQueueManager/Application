<?php

namespace App\Queues;

use PHPQueueManager\PHPQueueManager\Adapters\AdapterFactory;
use PHPQueueManager\PHPQueueManager\Queue\Queue;

class MailQueue extends Queue
{

    public function __construct()
    {
        $adapter = AdapterFactory::create('rabbitmq', [
            'host'          => 'localhost',
            'port'          => 5672,
            'username'      => 'guest',
            'password'      => 'guest',
        ]);
        parent::__construct($adapter);
    }

    public function getName(): string
    {
        return 'mail_queue';
    }

    public function getDLQName(): string
    {
        return 'mail_queue_dead_letter_queue';
    }

}
