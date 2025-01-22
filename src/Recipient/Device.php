<?php

namespace RedjanYm\FCM\Recipient;

class Device implements Recipient
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function getTarget(): string
    {
        return $this->token;
    }
}
