<?php
    
namespace HtMessaging\Entity;

class Message implements MessageInterface
{
    protected $id;

    protected $senderId;

    protected $subject;

    protected $messageText;

    protected $createdDateTime;

    protected $starredOrNot = self::NOT_STARRED;

    protected $importantOrNot = self::NOT_IMPORTANT;

    const STARRED = 1;

    const NOT_STARRED = 0;

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

    public function setSenderId($senderId)
    {
        $this->senderId = $senderId;
    }

    public function getSenderId()
    {
        return $this->senderId;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setMessageText($messageText)
    {
        $this->messageText = $messageText;
    }

    public function getMessageText()
    {
        return $this->messageText;
    }

    public function setCreatedDateTime($createdDateTime)
    {
        $this->createdDateTime = $createdDateTime;
    }

    public function getCreatedDateTime()
    {
        return $this->createdDateTime;
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
