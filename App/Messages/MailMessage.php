<?php

namespace App\Messages;

use PHPQueueManager\PHPQueueManager\Queue\JobMessageInterface;
use PHPQueueManager\PHPQueueManager\Queue\Message;
use PHPQueueManager\PHPQueueManager\Queue\MessageInterface;

class MailMessage extends Message implements JobMessageInterface
{

    /**
     * @inheritDoc
     */
    public function worker(\PHPQueueManager\PHPQueueManager\Queue\MessageInterface $message): bool
    {
        try {
            $payload = $message->getPayload();
            if (filter_var($payload['to_mail'], FILTER_VALIDATE_EMAIL)) {
                sleep(2);

                return true;
            }

            return false;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function mail(string $toMail, string $subject, string $body)
    {
        $this->setPayload([
            'to_mail'           => $toMail,
            'subject'           => $subject,
            'body'              => $body,
        ]);
    }

}
