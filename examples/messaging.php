<?php

include_once '../vendor/autoload.php';

use RedjanYm\FCM\Client;
use RedjanYm\FCM\Notification;
use RedjanYm\FCM\Recipient\Device;
use RedjanYm\FCM\Recipient\Topic;

$serviceAccountPath = 'service-account.json';

$client = new Client($serviceAccountPath);

// -------------------------------------------------------
// Send a basic notification to a device
// -------------------------------------------------------

$recipient = new Device('your-device-token');
$notification = new Notification($recipient, 'Hello!', 'This is a test notification.');

$response = $client->send($notification);
echo "Device notification: " . $response->getBody()->getContents() . PHP_EOL;

// -------------------------------------------------------
// Send a notification to a topic
// -------------------------------------------------------

$recipient = new Topic('news');
$notification = new Notification($recipient, 'Breaking News', 'Something happened!');

$response = $client->send($notification);
echo "Topic notification: " . $response->getBody()->getContents() . PHP_EOL;

// -------------------------------------------------------
// Send a notification with data payload
// -------------------------------------------------------

$recipient = new Device('your-device-token');
$notification = new Notification($recipient, 'Order Update', 'Your order has shipped.', [
    'order_id' => '12345',
    'status' => 'shipped',
]);

$response = $client->send($notification);
echo "Data notification: " . $response->getBody()->getContents() . PHP_EOL;

// -------------------------------------------------------
// Send a notification with platform-specific options
// -------------------------------------------------------

$recipient = new Device('your-device-token');
$notification = new Notification($recipient, 'Alert', 'High priority message');

// Android
$notification->androidPriority = 'high';
$notification->androidChannelId = 'alerts';
$notification->icon = 'ic_alert';
$notification->color = '#FF0000';
$notification->sound = 'default';
$notification->clickAction = 'OPEN_ALERTS';

// APNs (iOS)
$notification->apnsPriority = '10';
$notification->badge = 1;
$notification->sound = 'default';

// Image
$notification->image = 'https://example.com/image.png';

// Analytics
$notification->analyticsLabel = 'alert_campaign';

// TTL
$notification->ttl = '86400s';

// Extra platform-specific settings
$notification->extraNotificationSettings = ['tag' => 'alert-tag'];
$notification->extraAPNSHeadersSettings = ['apns-collapse-id' => 'alerts'];
$notification->webPushHeadersSettings = ['Urgency' => 'high'];

$response = $client->send($notification);
echo "Custom notification: " . $response->getBody()->getContents() . PHP_EOL;
