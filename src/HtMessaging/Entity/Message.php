<?php
    
namespace HtMessaging\Entity;

class Message implements MessageInterface
{
    protected $id;

    protected $senderId;

    protected $subject;

    protected $messageText;

    protected $createdDateTime;

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
}
