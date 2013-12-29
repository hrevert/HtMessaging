<?php
    
namespace HtMessaging;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    protected $displayUserImage = false;

    protected $sendEmailMessage = false;

    protected $enableMultipleReceivers = false; 

    protected $messageEntityClass = "HtMessaging\Entity\Message";

    protected $messageReceiverEntityClass = "HtMessaging\Entity\MessageReceiver";

    public function setDisplayUserImage($displayUserImage)
    {
        $this->displayUserImage = $displayUserImage;
    }

    public function getDisplayUserImage()
    {
        return $this->displayUserImage;
    }

    public function setSendEmailMessage($sendEmailMessage)
    {
        $this->sendEmailMessage = $sendEmailMessage;
    }

    public function getSendEmailMessage()
    {
        return $this->sendEmailMessage;
    }

    public function setEnableMultipleReceivers($enableMultipleReceivers)
    {
        $this->enableMultipleReceivers = $enableMultipleReceivers;
    }

    public function getEnableMultipleReceivers()
    {
        return $this->enableMultipleReceivers;
    }

    public function setMessageEntityClass($messageEntityClass)
    {
        $this->messageEntityClass = $messageEntityClass;
    }

    public function getMessageEntityClass()
    {
        return $this->messageEntityClass;
    }

    public function setMessageReceiverEntityClass($messageReceiverEntityClass)
    {
        $this->messageReceiverEntityClass = $messageReceiverEntityClass;
    }

    public function getMessageReceiverEntityClass()
    {
        return $this->messageReceiverEntityClass;
    }
}
