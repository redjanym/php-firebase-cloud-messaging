<?php

namespace RedjanYm\FCM\Recipient;

interface Recipient
{
    public function getTarget(): string;
    public function getType(): string;
}
