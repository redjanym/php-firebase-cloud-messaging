# PHP Firebase Cloud Messaging

<a href='https://www.paypal.me/ymerajredjan' target='_blank'><img height='36' style='border:0px;height:36px;' src='https://az743702.vo.msecnd.net/cdn/kofi2.png?v=0' border='0' alt='Buy Me a Coffee at ko-fi.com' /></a>

PHP SDK for Firebase Cloud Messaging from Google, supporting HTTP V1.

See original Firebase docs: https://firebase.google.com/docs/

#Setup
Install via Composer:
```
composer require redjanym/php-firebase-cloud-messaging
```

Or add this to your composer.json and run "composer update":

```
"require": {
    "redjanym/php-firebase-cloud-messaging": "2.*"
}
```

# Send message to a Device
```
use RedjanYm\FCM\Client;
use RedjanYm\FCM\Notification;
use RedjanYm\FCM\Recipient\Device;

$serviceAccountPath = '/path/to/service-account.json';
$testToken = 'this-is-a-token';

$client = new Client($serviceAccountPath);
$recipient = new Device($testToken);
$notification = new Notification($recipient, 'Title', 'Body', ['key' => 'value']);

$client->send($notification);
```

# Topic Support
The current version does not have support for Topics. We are going to add it on v2.1.

# Migrating from V1.
Unfortunately V2 of this package introduces breaking changes. But the new structure of the SDK is still simple and very similar to the previous one. We are sure the migration is going to be very fast and easy.

# Interpreting responses
Responses given on the HTTP requests are standard according to the FCM documentations. You may find detailed specifications in this links:
* https://firebase.google.com/docs/cloud-messaging/http-server-ref#interpret-downstream
* https://firebase.google.com/docs/cloud-messaging/http-server-ref#error-codes
