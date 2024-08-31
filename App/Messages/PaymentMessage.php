<?php

namespace App\Messages;

use PHPQueueManager\PHPQueueManager\Queue\Message;

class PaymentMessage extends Message
{

    public function retryNotification(): bool
    {
        // It failed and will be retried.
        return true;
    }

    public function deadLetterNotification(): bool
    {
        // It failed and the message was written as an dead letter.
        return true;
    }

}
