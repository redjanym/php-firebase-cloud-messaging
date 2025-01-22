<?php

namespace RedjanYm\FCM;

use RedjanYm\FCM\Recipient\Recipient;

class Message
{
    private Recipient $recipient;

    public function setRecipient(Recipient $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * @throws \Exception
     */
    private function createTo(): string
    {
        return $this->recipient->getTarget();
    }
}
