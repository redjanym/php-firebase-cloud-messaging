<?php

namespace RedjanYm\FCM;

use Psr\Http\Message\ResponseInterface;

interface ClientInterface
{
    public function setServiceAccountPath(string $serviceAccountPath): self;

    public function send(Notification $message): ResponseInterface;
}
