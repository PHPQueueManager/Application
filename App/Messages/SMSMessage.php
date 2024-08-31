<?php

namespace App\Messages;

use PHPQueueManager\PHPQueueManager\Queue\JobMessageInterface;
use PHPQueueManager\PHPQueueManager\Queue\Message;
use PHPQueueManager\PHPQueueManager\Queue\MessageInterface;

class SMSMessage extends Message implements JobMessageInterface
{

    /**
     * @inheritDoc
     */
    public function worker(\PHPQueueManager\PHPQueueManager\Queue\MessageInterface $message): bool
    {
        try {
            $payload = $message->getPayload();
            if (!empty($payload['phone_number'])) {
                sleep(2);

                return true;
            }

            return false;
        } catch (\Throwable $e) {
            return false;
        }
    }

}
