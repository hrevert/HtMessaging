<?php
    
namespace HtMessaging\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements 
    EntityOptionsInterface,
    MultipleReceiversOptionsInterface
{
    protected $displayUserImage = false;

    protected $sendEmailMessage = false;

    protected $enableMultipleReceivers = true; 

    protected $messageEntityClass = "HtMessaging\Entity\Message";

    protected $messageReceiverEntityClass = "HtMessaging\Entity\MessageReceiver";

    protected $loginRoute = "zfcuser\login";

    protected $allowDeleteMessage = true;

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

    public function setLoginRoute($loginRoute)
    {
        $this->loginRoute = $loginRoute;
    }

    public function getLoginRoute($loginRoute)
    {
        return $this->loginRoute;
    }

    public function setAllowDeleteMessage($allowDeleteMessage)
    {
        $this->allowDeleteMessage = $allowDeleteMessage;
    }

    public function getAllowDeleteMessage()
    {
        return $this->allowDeleteMessage;
    }
}
