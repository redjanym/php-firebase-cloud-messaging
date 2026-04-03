<?php

namespace RedjanYm\FCM\Tests;

use PHPUnit\Framework\TestCase;
use RedjanYm\FCM\Client;

class ClientTest extends TestCase
{
    public function testConstructorThrowsOnMissingFile(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Service account file does not exist!');

        new Client('/nonexistent/path/service-account.json');
    }

    public function testSetServiceAccountPathThrowsOnMissingFile(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Service account file does not exist!');

        // Use reflection to create Client without calling constructor,
        // then test setServiceAccountPath independently.
        $reflection = new \ReflectionClass(Client::class);
        $client = $reflection->newInstanceWithoutConstructor();

        $client->setServiceAccountPath('/nonexistent/path/service-account.json');
    }
}
