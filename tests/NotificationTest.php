<?php

namespace RedjanYm\FCM\Tests;

use PHPUnit\Framework\TestCase;
use RedjanYm\FCM\Notification;
use RedjanYm\FCM\Recipient\Device;
use RedjanYm\FCM\Recipient\Topic;

class NotificationTest extends TestCase
{
    public function testJsonSerializeWithDevice(): void
    {
        $recipient = new Device('test-token');
        $notification = new Notification($recipient, 'Test Title', 'Test Body', ['key' => 'value']);

        $json = $notification->jsonSerialize();

        $this->assertSame('test-token', $json['token']);
        $this->assertArrayNotHasKey('topic', $json);
        $this->assertSame('Test Title', $json['notification']['title']);
        $this->assertSame('Test Body', $json['notification']['body']);
        $this->assertSame(['key' => 'value'], $json['data']);
    }

    public function testJsonSerializeWithTopic(): void
    {
        $recipient = new Topic('news');
        $notification = new Notification($recipient, 'Test Title', 'Test Body');

        $json = $notification->jsonSerialize();

        $this->assertSame('news', $json['topic']);
        $this->assertArrayNotHasKey('token', $json);
        $this->assertSame('Test Title', $json['notification']['title']);
        $this->assertSame('Test Body', $json['notification']['body']);
    }

    public function testJsonSerializeWithNullBody(): void
    {
        $recipient = new Device('test-token');
        $notification = new Notification($recipient, 'Title Only');

        $json = $notification->jsonSerialize();

        $this->assertSame('Title Only', $json['notification']['title']);
        $this->assertNull($json['notification']['body']);
    }

    public function testDefaultDataIsEmptyArray(): void
    {
        $recipient = new Device('test-token');
        $notification = new Notification($recipient, 'Title');

        $json = $notification->jsonSerialize();

        $this->assertSame([], $json['data']);
    }

    public function testAndroidConfig(): void
    {
        $recipient = new Device('test-token');
        $notification = new Notification($recipient, 'Title', 'Body');
        $notification->androidPriority = 'high';
        $notification->ttl = '7200s';
        $notification->androidChannelId = 'my_channel';

        $json = $notification->jsonSerialize();

        $this->assertSame('high', $json['android']['priority']);
        $this->assertSame('7200s', $json['android']['ttl']);
        $this->assertSame('my_channel', $json['android']['notification']['channel_id']);
    }

    public function testApnsConfig(): void
    {
        $recipient = new Device('test-token');
        $notification = new Notification($recipient, 'Title', 'Body');
        $notification->apnsPriority = '5';
        $notification->badge = 3;
        $notification->sound = 'default';

        $json = $notification->jsonSerialize();

        $this->assertSame('5', $json['apns']['headers']['apns-priority']);
        $this->assertSame(3, $json['apns']['payload']['aps']['badge']);
        $this->assertSame('default', $json['apns']['payload']['aps']['sound']);
    }

    public function testWebPushConfig(): void
    {
        $recipient = new Device('test-token');
        $notification = new Notification($recipient, 'Title', 'Body');
        $notification->icon = 'https://example.com/icon.png';

        $json = $notification->jsonSerialize();

        $this->assertSame('Title', $json['webpush']['notification']['title']);
        $this->assertSame('Body', $json['webpush']['notification']['body']);
        $this->assertSame('https://example.com/icon.png', $json['webpush']['notification']['icon']);
    }

    public function testWebPushHeaders(): void
    {
        $recipient = new Device('test-token');
        $notification = new Notification($recipient, 'Title', 'Body');
        $notification->webPushHeadersSettings = ['Urgency' => 'high'];

        $json = $notification->jsonSerialize();

        $this->assertSame(['Urgency' => 'high'], $json['webpush']['headers']);
    }

    public function testWebPushHeadersOmittedWhenEmpty(): void
    {
        $recipient = new Device('test-token');
        $notification = new Notification($recipient, 'Title', 'Body');

        $json = $notification->jsonSerialize();

        $this->assertArrayNotHasKey('headers', $json['webpush']);
    }

    public function testImageProperty(): void
    {
        $recipient = new Device('test-token');
        $notification = new Notification($recipient, 'Title', 'Body');
        $notification->image = 'https://example.com/image.png';

        $json = $notification->jsonSerialize();

        $this->assertSame('https://example.com/image.png', $json['notification']['image']);
    }

    public function testAnalyticsLabel(): void
    {
        $recipient = new Device('test-token');
        $notification = new Notification($recipient, 'Title', 'Body');
        $notification->analyticsLabel = 'campaign_123';

        $json = $notification->jsonSerialize();

        $this->assertSame('campaign_123', $json['android']['fcm_options']['analytics_label']);
        $this->assertSame('campaign_123', $json['apns']['fcm_options']['analytics_label']);
        $this->assertSame('campaign_123', $json['webpush']['fcm_options']['analytics_label']);
        $this->assertSame('campaign_123', $json['fcm_options']['analytics_label']);
    }

    public function testExtraNotificationSettings(): void
    {
        $recipient = new Device('test-token');
        $notification = new Notification($recipient, 'Title', 'Body');
        $notification->extraNotificationSettings = ['tag' => 'my-tag'];

        $json = $notification->jsonSerialize();

        $this->assertSame('my-tag', $json['android']['notification']['tag']);
    }

    public function testExtraAPNSHeadersSettings(): void
    {
        $recipient = new Device('test-token');
        $notification = new Notification($recipient, 'Title', 'Body');
        $notification->extraAPNSHeadersSettings = ['apns-collapse-id' => 'campaign'];

        $json = $notification->jsonSerialize();

        $this->assertSame('campaign', $json['apns']['headers']['apns-collapse-id']);
    }

    public function testClickAction(): void
    {
        $recipient = new Device('test-token');
        $notification = new Notification($recipient, 'Title', 'Body');
        $notification->clickAction = 'OPEN_ACTIVITY';

        $json = $notification->jsonSerialize();

        $this->assertSame('OPEN_ACTIVITY', $json['android']['notification']['click_action']);
    }

    public function testJsonEncodeProducesValidJson(): void
    {
        $recipient = new Device('test-token');
        $notification = new Notification($recipient, 'Title', 'Body', ['key' => 'value']);

        $encoded = json_encode($notification);

        $this->assertIsString($encoded);
        $this->assertNotFalse($encoded);

        $decoded = json_decode($encoded, true);
        $this->assertSame('test-token', $decoded['token']);
        $this->assertSame('Title', $decoded['notification']['title']);
    }
}
