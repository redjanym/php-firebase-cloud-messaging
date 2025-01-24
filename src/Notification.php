<?php

namespace RedjanYm\FCM;

use RedjanYm\FCM\Recipient\Recipient;

class Notification implements \JsonSerializable
{
    public Recipient $recipient;
    public ?string $title;
    public ?string $body;
    public array $data;
    public ?string $image = null;
    public string $androidPriority = 'normal';
    public string $apnsPriority = '10';
    public string $ttl = '3600s';
    public ?int $badge = 0;
    public ?string $icon = null;
    public ?string $color = null;
    public string $sound = '';
    public bool $contentAvailable = true;
    public ?string $analyticsLabel = null;
    public ?string $clickAction = null;
    public ?string $androidChannelId = null;
    public array $extraNotificationSettings = [];
    public array $extraFCMOptionsSettings = [];
    public array $extraAPNSHeadersSettings = [];
    public array $webPushHeadersSettings = [];

    public function __construct(Recipient $recipient, string $title, ?string $body = null, array $data = [])
    {
        $this->title = $title;
        $this->body = $body;
        $this->data = $data;
        $this->recipient = $recipient;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            $this->recipient->getType() => $this->recipient->getTarget(),
            'notification' => [
                'title' => $this->title,
                'body' => $this->body,
                'image' => $this->image,
            ],
            'data' => $this->data,
            'android' => [
                // https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages#androidconfig
                'ttl' => $this->ttl,
                'priority' => $this->androidPriority,
                'notification' => [
                    'title' => $this->title,
                    'body' => $this->body,
                    'icon' => $this->icon,
                    'color' => $this->color,
                    'sound' => $this->sound,
                    'click_action' => $this->clickAction,
                    'channel_id' => $this->androidChannelId,
                    ...$this->extraNotificationSettings,
                ],
                'fcm_options' => [
                    // https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages#fcmoptions
                    'analytics_label' => $this->analyticsLabel,
                    ...$this->extraFCMOptionsSettings,
                ],
            ],
            'apns' => [
                // https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages#apnsconfig
                'headers' => [
                    'apns-priority' => $this->apnsPriority,
                    ...$this->extraAPNSHeadersSettings,
                ],
                'payload' => [
                    'aps' => [
                        'alert' => [
                            'title' => $this->title,
                            'body' => $this->body,
                        ],
                        'sound' => $this->sound,
                        'badge' => $this->badge,
                        'content_available' => $this->contentAvailable,
                    ],
                ],
                'fcm_options' => [
                    // https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages#fcmoptions
                    'analytics_label' => $this->analyticsLabel,
                    ...$this->extraFCMOptionsSettings,
                ],
            ],
            'webpush' => array_merge([
                    // https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages#webpushconfig
                    'notification' => [
                        'title' => $this->title,
                        'body' => $this->body,
                        'icon' => $this->icon,
                    ],
                    'fcm_options' => [
                        // https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages#webpushfcmoptions
                        'analytics_label' => $this->analyticsLabel,
                        ...$this->extraFCMOptionsSettings,
                    ],
                    'data' => $this->data,
                ],
                $this->webPushHeadersSettings != [] ? ['headers' => $this->webPushHeadersSettings] : [],
            ),
            'fcm_options' => [
                // https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages#fcmoptions
                'analytics_label' => $this->analyticsLabel,
                ...$this->extraFCMOptionsSettings,
            ],
        ];
    }
}
