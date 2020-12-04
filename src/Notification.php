<?php
namespace sngrl\PhpFirebaseCloudMessaging;

/**
 * @link https://firebase.google.com/docs/cloud-messaging/http-server-ref#notification-payload-support
 */
class Notification extends Message
{
    private $title;
    private $subtitle;
    private $body;
    private $badge;
    private $icon;
    private $image;
    private $color;
    private $sound;
    private $clickAction;
    private $tag;
    private $contentAvailable;
    private $bodyLocKey;
    private $bodyLocArgs;
    private $titleLocKey;
    private $titleLocArgs;
    private $androidChannelId;

    public function __construct($title = '', $body = '')
    {
        if ($title)
            $this->title = $title;
        if ($body)
            $this->body = $body;
        parent::__construct();
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * iOS only, will add smal red bubbles indicating the number of notifications to your apps icon
     *
     * @param integer $badge
     * @return $this
     */
    public function setBadge($badge)
    {
        $this->badge = $badge;
        return $this;
    }

    /**
     * android only, set the name of your drawable resource as string
     *
     * @param string $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }
    
    /**
     * android only, set the color background resource as string
     *
     * @param string $color
     * @return $this
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    public function setClickAction($actionName)
    {
        $this->clickAction = $actionName;
        return $this;
    }

    public function setSound($sound)
    {
        $this->sound = $sound;
        return $this;
    }

    public function setTag($tag)
    {
        $this->tag = $tag;
        return $this;
    }

    public function setContentAvailable($contentAvailable)
    {
        $this->contentAvailable = $contentAvailable;
        return $this;
    }

    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
        return $this;
    }

    public function setBodyLocKey($bodyLocKey)
    {
        $this->bodyLocKey = $bodyLocKey;
        return $this;
    }

    public function setBodyLocArgs($bodyLocArgs)
    {
        $this->bodyLocArgs = $bodyLocArgs;
        return $this;
    }

    public function setTitleLocKey($titleLocKey)
    {
        $this->titleLocKey = $titleLocKey;
        return $this;
    }

    public function setTitleLocArgs($titleLocArgs)
    {
        $this->titleLocArgs = $titleLocArgs;
        return $this;
    }

    public function setAndroidChannelId($androidChannelId)
    {
        $this->androidChannelId = $androidChannelId;
        return $this;
    }

    public function hasNotificationData()
    {
        return
            $this->title ||
            $this->body ||
            $this->badge ||
            $this->icon ||
            $this->clickAction ||
            $this->sound ||
            $this->tag ||
            $this->contentAvailable ||
            $this->subtitle ||
            $this->titleLocKey ||
            $this->titleLocArgs ||
            $this->bodyLocKey ||
            $this->bodyLocArgs ||
            $this->androidChannelId ||
            $this->image
        ;
    }

    public function jsonSerialize()
    {
        $jsonData = [];

        if ($this->title) {
            $jsonData['title'] = $this->title;
        }
        if ($this->body) {
            $jsonData['body'] = $this->body;
        }
        if ($this->badge) {
            $jsonData['badge'] = $this->badge;
        }
        if ($this->icon) {
            $jsonData['icon'] = $this->icon;
        }
        if ($this->image) {
            $jsonData['image'] = $this->image;
        }
        if ($this->color) {
            $jsonData['color'] = $this->color;
        }
        if ($this->clickAction) {
            $jsonData['click_action'] = $this->clickAction;
        }
        if ($this->sound) {
            $jsonData['sound'] = $this->sound;
        }
        if ($this->tag) {
            $jsonData['tag'] = $this->tag;
        }
        if ($this->contentAvailable) {
            $jsonData['content_available'] = $this->contentAvailable;
        }
        if ($this->subtitle) {
            $jsonData['subtitle'] = $this->subtitle;
        }
        if ($this->androidChannelId) {
            $jsonData['android_channel_id'] = $this->androidChannelId;
        }
        if ($this->titleLocKey) {
            $jsonData['title_loc_key'] = $this->titleLocKey;
        }
        if ($this->titleLocArgs) {
            $jsonData['title_loc_args'] = $this->titleLocArgs;
        }
        if ($this->bodyLocKey) {
            $jsonData['body_loc_key'] = $this->bodyLocKey;
        }
        if ($this->bodyLocArgs) {
            $jsonData['body_loc_args'] = $this->bodyLocArgs;
        }

        return $jsonData;
    }
}
