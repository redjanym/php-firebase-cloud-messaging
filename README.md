# PHP Firebase Cloud Messaging

<a href='https://www.paypal.me/ymerajredjan' target='_blank'><img height='36' style='border:0px;height:36px;' src='https://az743702.vo.msecnd.net/cdn/kofi2.png?v=0' border='0' alt='Buy Me a Coffee at ko-fi.com' /></a>

PHP SDK for Firebase Cloud Messaging from Google, supporting the HTTP V1 API.

See the official Firebase docs: https://firebase.google.com/docs/cloud-messaging

## Requirements

- PHP >= 7.4
- A Firebase service account JSON file ([how to generate one](https://firebase.google.com/docs/admin/setup#initialize_the_sdk_in_non-google_environments))

## Setup

Install via Composer:

```bash
composer require redjanym/php-firebase-cloud-messaging
```

Or add this to your `composer.json` and run `composer update`:

```json
"require": {
    "redjanym/php-firebase-cloud-messaging": "2.*"
}
```

## Usage

### Send a Message to a Device

```php
use RedjanYm\FCM\Client;
use RedjanYm\FCM\Notification;
use RedjanYm\FCM\Recipient\Device;

$serviceAccountPath = '/path/to/service-account.json';

$client = new Client($serviceAccountPath);
$recipient = new Device('your-device-token');
$notification = new Notification($recipient, 'Title', 'Body', ['key' => 'value']);

$response = $client->send($notification);
```

### Send a Message to a Topic

```php
use RedjanYm\FCM\Client;
use RedjanYm\FCM\Notification;
use RedjanYm\FCM\Recipient\Topic;

$serviceAccountPath = '/path/to/service-account.json';

$client = new Client($serviceAccountPath);
$recipient = new Topic('news');
$notification = new Notification($recipient, 'Title', 'Body', ['key' => 'value']);

$response = $client->send($notification);
```

Clients subscribe to topics from the client app. See the [Firebase topic documentation](https://firebase.google.com/docs/cloud-messaging/android/topic-messaging) for details on managing topic subscriptions.

### Customizing Notifications

The `Notification` object exposes public properties for platform-specific configuration:

```php
$notification = new Notification($recipient, 'Title', 'Body');

// Android
$notification->androidPriority = 'high';
$notification->androidChannelId = 'my_channel';
$notification->icon = 'ic_notification';
$notification->color = '#FF0000';

// APNs (iOS)
$notification->apnsPriority = '10';
$notification->badge = 5;
$notification->sound = 'default';
$notification->contentAvailable = true;

// General
$notification->image = 'https://example.com/image.png';
$notification->ttl = '3600s';
$notification->clickAction = 'OPEN_ACTIVITY';
$notification->analyticsLabel = 'campaign_123';

// Additional platform-specific settings via extra arrays
$notification->extraNotificationSettings = ['tag' => 'my-tag'];
$notification->extraAPNSHeadersSettings = ['apns-collapse-id' => 'campaign'];
$notification->webPushHeadersSettings = ['Urgency' => 'high'];
```

## Testing

Install dev dependencies and run the test suite with PHPUnit:

```bash
composer install
vendor/bin/phpunit
```

To run a specific test file:

```bash
vendor/bin/phpunit tests/NotificationTest.php
```

To run a specific test method:

```bash
vendor/bin/phpunit --filter testJsonSerializeWithTopic
```

## Migrating from V1

V2 of this package introduces breaking changes due to the migration from the legacy FCM API to the HTTP V1 API. The new structure is still simple and very similar to the previous one.

## Interpreting Responses

The `send()` method returns a PSR-7 `ResponseInterface`. Responses follow the standard FCM specifications:

- [Downstream message responses](https://firebase.google.com/docs/cloud-messaging/http-server-ref#interpret-downstream)
- [Error codes](https://firebase.google.com/docs/cloud-messaging/http-server-ref#error-codes)
