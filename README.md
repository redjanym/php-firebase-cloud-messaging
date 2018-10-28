# PHP Firebase Cloud Messaging

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/83a88985-9752-463b-ae62-7abb06aea791/big.png)](https://insight.sensiolabs.com/projects/83a88985-9752-463b-ae62-7abb06aea791)
<a href='https://www.paypal.me/ymerajredjan' target='_blank'><img height='36' style='border:0px;height:36px;' src='https://az743702.vo.msecnd.net/cdn/kofi2.png?v=0' border='0' alt='Buy Me a Coffee at ko-fi.com' /></a>

PHP API for Firebase Cloud Messaging from Google.

Currently this app server library only supports sending Messages/Notifications via HTTP.

See original Firebase docs: https://firebase.google.com/docs/

#Setup
Install via Composer:
```
composer require redjanym/php-firebase-cloud-messaging
```

Or add this to your composer.json and run "composer update":

```
"require": {
    "redjanym/php-firebase-cloud-messaging": "1.*"
}
```

# Send message to **one or multiple** Devices
```
use sngrl\PhpFirebaseCloudMessaging\Client;
use sngrl\PhpFirebaseCloudMessaging\Message;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Device;
use sngrl\PhpFirebaseCloudMessaging\Notification;

$server_key = '_YOUR_SERVER_KEY_';
$client = new Client();
$client->setApiKey($server_key);

$message = new Message();
$message->setPriority('high');
$message->addRecipient(new Device('_YOUR_DEVICE_TOKEN_'));
$message
    ->setNotification(new Notification('some title', 'some body'))
    ->setData(['key' => 'value'])
;

$response = $client->send($message);
var_dump($response->getStatusCode());
var_dump($response->getBody()->getContents());
```

# Send message to Topic
Currently sending to topics only supports a single topic as recipient. Mutliple topic as outlined
in the google docs don't seem to work, yet.
```
use sngrl\PhpFirebaseCloudMessaging\Client;
use sngrl\PhpFirebaseCloudMessaging\Message;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Topic;
use sngrl\PhpFirebaseCloudMessaging\Notification;

$server_key = '_YOUR_SERVER_KEY_';
$client = new Client();
$client->setApiKey($server_key);

$message = new Message();
$message->setPriority('high');
$message->addRecipient(new Topic('_YOUR_TOPIC_'));
$message
    ->setNotification(new Notification('some title', 'some body'))
    ->setData(['key' => 'value'])
;

$response = $client->send($message);
var_dump($response->getStatusCode());
var_dump($response->getBody()->getContents());
```

# Subscribe user to the topic
```
use sngrl\PhpFirebaseCloudMessaging\Client;

$server_key = '_YOUR_SERVER_KEY_';
$client = new Client();
$client->setApiKey($server_key);

$response = $client->addTopicSubscription('_SOME_TOPIC_ID_', ['_FIRST_TOKEN_', '_SECOND_TOKEN_']);
var_dump($response->getStatusCode());
var_dump($response->getBody()->getContents());
```

# Remove user subscription to the topic
```
use sngrl\PhpFirebaseCloudMessaging\Client;

$server_key = '_YOUR_SERVER_KEY_';
$client = new Client();
$client->setApiKey($server_key);

$response = $client->removeTopicSubscription('_SOME_TOPIC_ID_', ['_FIRST_TOKEN_', '_SECOND_TOKEN_']);
var_dump($response->getStatusCode());
var_dump($response->getBody()->getContents());
```

# Interpreting responses
Responses given on the HTTP requests are standard according to the FCM documentations. You may find detailed specifications in this links:
* https://firebase.google.com/docs/cloud-messaging/http-server-ref#interpret-downstream
* https://firebase.google.com/docs/cloud-messaging/http-server-ref#error-codes