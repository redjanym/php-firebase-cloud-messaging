<?php

namespace RedjanYm\FCM\Tests;

use PHPUnit\Framework\TestCase;
use RedjanYm\FCM\Recipient\Topic;

class TopicTest extends TestCase
{
    public function testGetTarget(): void
    {
        $topic = new Topic('news');

        $this->assertSame('news', $topic->getTarget());
    }

    public function testGetType(): void
    {
        $topic = new Topic('news');

        $this->assertSame('topic', $topic->getType());
    }
}
