<?php
    
namespace HtMessaging;

interface EntityOptionsInterface
{
    public function setMessageEntityClass($messageEntityClass);

    public function getMessageEntityClass();

    public function setMessageReceiverEntityClass($messageReceiverEntityClass);

    public function getMessageReceiverEntityClass();
}
