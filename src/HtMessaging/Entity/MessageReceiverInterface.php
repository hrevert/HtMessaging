<?php
namespace HtMessaging\Entity;

interface MessageReceiverInterface
{
    public function setId($id);

    public function getId();

    public function setMessageId($messageId);

    public function getMessageId();

    public function setReceiverId($receiverId);

    public function getReceiverId();

    public function setSentDateTime($sentDateTime);

    public function getSentDateTime();

    public function setReceivedOrNot($receivedOrNot);

    public function getReceivedOrNot();

    public function isReceived();

    public function setStarredOrNot($starredOrNot);

    public function getStarredOrNot();

    public function isStarred();

    public function setImportantOrNot($importantOrNot);

    public function getImportantOrNot();

    public function isImportant();
}
