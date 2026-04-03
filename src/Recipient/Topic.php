<?php

namespace RedjanYm\FCM\Recipient;

class Topic implements Recipient
{
    private string $topic;

    public function __construct(string $topic)
    {
        $this->topic = $topic;
    }

    public function getTarget(): string
    {
        return $this->topic;
    }

    public function getType(): string
    {
        return 'topic';
    }
}
