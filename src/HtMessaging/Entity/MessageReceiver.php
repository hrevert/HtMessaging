<?php

namespace HtMessaging\Entity;

class MessageReceiver implements MessageReceiverInterface
{
    protected $id;

    protected $messageId;

    protected $receiverId;

    protected $sentDateTime;

    protected $starredOrNot = 0;

    protected $receivedOrNot = 0;

    protected $importantOrNot = 0;

    const STARRED = 1;

    const NOT_STARRED = 0;

    const RECEIVED = 1;

    const NOT_RECEIVED = 0;

    const IMPORTANT = 1;

    const NOT_IMPORTANT = 1;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;
    }

    public function getMessageId()
    {
        return $this->messageId;
    }

    public function setReceiverId($receiverId)
    {
        $this->receiverId = $receiverId;
    }

    public function getReceiverId()
    {
        return $this->receiverId;
    }

    public function setSentDateTime($sentDateTime)
    {
        $this->sentDateTime = $sentDateTime;
    }

    public function getSentDateTime()
    {
        return $this->sentDateTime;
    }

    public function setReceivedOrNot($receivedOrNot)
    {
        $this->receivedOrNot = $receivedOrNot;
    }

    public function getReceivedOrNot()
    {
        return $this->receivedOrNot;
    }

    public function isReceived()
    {
        return $this->getReceivedOrNot() === static::RECEIVED;
    }

    public function setStarredOrNot($starredOrNot)
    {
        $this->starredOrNot = $starredOrNot;
    }

    public function getStarredOrNot()
    {
        return $this->starredOrNot;
    }

    public function isStarred()
    {
        return $this->getStarredOrNot() === static::STARRED;
    }

    public function setImportantOrNot($importantOrNot)
    {
        $this->importantOrNot = $importantOrNot;
    }

    public function getImportantOrNot()
    {
        return $this->importantOrNot;
    }

    public function isImportant()
    {
        return $this->getImportantOrNot() === static::IMPORTANT;
    }
}
