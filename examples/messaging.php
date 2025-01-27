<?php

include_once '../vendor/autoload.php';

use RedjanYm\FCM\Client;
use RedjanYm\FCM\Notification;
use RedjanYm\FCM\Recipient\Device;

$serviceAccountPath = 'service-account.json';
$testToken = '123456789';

$client = new Client($serviceAccountPath);
$recipient = new Device($testToken);
$notification = new Notification($recipient, 'Title', 'Body', ['key' => 'value']);

$response = $client->send($notification);
dump($response->getBody()->getContents());
