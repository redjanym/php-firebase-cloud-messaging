<?php

namespace RedjanYm\FCM\Tests;

use PHPUnit\Framework\TestCase;
use RedjanYm\FCM\Recipient\Device;

class DeviceTest extends TestCase
{
    public function testGetTarget(): void
    {
        $device = new Device('test-token-123');

        $this->assertSame('test-token-123', $device->getTarget());
    }

    public function testGetType(): void
    {
        $device = new Device('test-token-123');

        $this->assertSame('token', $device->getType());
    }
}
