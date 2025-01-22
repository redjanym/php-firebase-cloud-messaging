<?php

namespace RedjanYm\FCM;

class Notification extends Message implements \JsonSerializable
{
    public ?string $title;
    private ?string $body;
    private array $data;
    private ?string $image;
    private string $androidPriority = 'normal';
    private int $apnsPriority = 10;
    private string $ttl = '3600s';
    private ?string $badge;
    private ?string $icon;
    private ?string $color;
    private ?string $sound;
    private bool $contentAvailable = true;
    private ?string $analyticsLabel;
    private ?string $clickAction;
    private ?string $androidChannelId;
    private array $extraNotificationSettings = [];
    private array $extraFCMOptionsSettings = [];
    private array $extraAPNSHeadersSettings = [];
    private array $webPushHeadersSettings = [];

    public function __construct(string $title = '', string $body = '', array $data = [])
    {
        $this->title = $title;
        $this->body = $body;
        $this->data = $data;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function setAndroidPriority(string $androidPriority): self
    {
        $this->androidPriority = $androidPriority;

        return $this;
    }

    public function setTtl(string $ttl): self
    {
        $this->ttl = $ttl;

        return $this;
    }

    public function setBadge(?string $badge): self
    {
        $this->badge = $badge;

        return $this;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function setClickAction(?string $actionName): self
    {
        $this->clickAction = $actionName;

        return $this;
    }

    public function setSound(?string $sound): self
    {
        $this->sound = $sound;

        return $this;
    }

    public function setAndroidChannelId(string $androidChannelId): self
    {
        $this->androidChannelId = $androidChannelId;

        return $this;
    }

    public function setAnalyticsLabel(?string $analyticsLabel): self
    {
        $this->analyticsLabel = $analyticsLabel;

        return $this;
    }

    public function setContentAvailable(bool $contentAvailable): self
    {
        $this->contentAvailable = $contentAvailable;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'notification' => [
                // https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages#notification
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
            'webpush' => [
                // https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages#webpushconfig
                'headers' => $this->webPushHeadersSettings,
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
            ],
            'fcm_options' => [
                // https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages#fcmoptions
                'analytics_label' => $this->analyticsLabel,
                ...$this->extraFCMOptionsSettings,
            ],
        ];
    }
}
