<?php
namespace sngrl\PhpFirebaseCloudMessaging;

use sngrl\PhpFirebaseCloudMessaging\Recipient\Recipient;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Topic;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Device;

/**
 * @author sngrl
 */
class Message implements \JsonSerializable
{
    private $notification;
    private $collapseKey;
    private $priority;
    private $contentAvailable;
    private $data;
    private $recipients = [];
    private $recipientType;
    private $jsonData;


    public function __construct() {
        $this->jsonData = [];
    }

    /**
     * where should the message go
     *
     * @param Recipient $recipient
     *
     * @return \sngrl\PhpFirebaseCloudMessaging\Message
     */
    public function addRecipient(Recipient $recipient)
    {
        $this->recipients[] = $recipient;

        if (!isset($this->recipientType)) {
            $this->recipientType = get_class($recipient);
        }
        if ($this->recipientType !== get_class($recipient)) {
            throw new \InvalidArgumentException('Mixed recipient types are not supported by FCM');
        }

        return $this;
    }

    public function setNotification(Notification $notification)
    {
        $this->notification = $notification;
        return $this;
    }

    public function setCollapseKey($collapseKey)
    {
        $this->collapseKey = $collapseKey;
        return $this;
    }

    public function getCollapseKey()
    {
        return $this->collapseKey;
    }

    public function setPriority($priority)
    {
        $this->priority = $priority;
        return $this;
    }

    public function getContentAvailable()
    {
        return $this->contentAvailable;
    }

    public function setContentAvailable($contentAvailable)
    {
        $this->contentAvailable = $contentAvailable;
        return $this;
    }

    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Set root message data via key
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setJsonKey($key, $value) {
        $this->jsonData[$key] = $value;
        return $this;
    }

    /**
     * Unset root message data via key
     *
     * @param string $key
     * @return $this
     */
    public function unsetJsonKey($key) {
        unset($this->jsonData[$key]);
        return $this;
    }

    /**
     * Get root message data via key
     *
     * @param string $key
     * @return mixed
     */
    public function getJsonKey($key) {
        return $this->jsonData[$key];
    }

    /**
     * Get root message data
     *
     * @return array
     */
    public function getJsonData() {
        return $this->jsonData;
    }

    /**
     * Set root message data
     *
     * @param array $array
     * @return $this
     */
    public function setJsonData($array) {
        $this->jsonData = $array;
        return $this;
    }


    public function setDelayWhileIdle($value)
    {
        $this->setJsonKey('delay_while_idle', (bool)$value);
        return $this;
    }

    public function setTimeToLive($value)
    {
        $this->setJsonKey('time_to_live', (int)$value);
        return $this;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $jsonData = $this->jsonData;

        if (empty($this->recipients)) {
            throw new \UnexpectedValueException('Message must have at least one recipient');
        }

        $target = $this->createTo();

        if(is_array($target)){
            $jsonData['registration_ids'] = $target;
        } else {
            $jsonData['to'] = $target;
        }

        if ($this->collapseKey) {
            $jsonData['collapse_key'] = $this->collapseKey;
        }
        if ($this->data) {
            $jsonData['data'] = $this->data;
        }
        if ($this->priority) {
            $jsonData['priority'] = $this->priority;
        }
        if ($this->contentAvailable) {
            $jsonData['content_available'] = $this->contentAvailable;
        }
        if ($this->notification && $this->notification->hasNotificationData()) {
            $jsonData['notification'] = $this->notification;
        }

        return $jsonData;
    }

    private function createTo()
    {
        switch ($this->recipientType) {
            case Topic::class:
                if (count($this->recipients) > 1) {
                    throw new \UnexpectedValueException(
                        'Currently messages to target multiple topics do not work, but its obviously planned: '.
                        'https://firebase.google.com/docs/cloud-messaging/topic-messaging#sending_topic_messages_from_the_server'
                    );
                }
                return sprintf('/topics/%s', current($this->recipients)->getName());
                break;
            case Device::class:
                if (count($this->recipients) == 1) {
                    return current($this->recipients)->getToken();
                } else {
                    return array_map(function(Device $device){
                        return $device->getToken();
                    }, $this->recipients);
                }

                break;
            default:
                throw new \UnexpectedValueException('PhpFirebaseCloudMessaging only supports single topic and single device messages yet');
                break;
        }
    }
}
