<?php

namespace HtMessaging\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use ZfcBase\EventManager\EventProvider;
use HtMessaging\Entity\MessageInterface;
use Zend\Db\Sql\Select;
use Zfcuser\Entity\UserInterface;

class MessagingService extends EventProvider implements ServiceLocatorAwareInterface
{
    /**
     *@var \HtMessaging\Options\ModuleOptions
     */
    protected $moduleOptions;

    protected $messageMapper;

    protected $messageReceiverMapper;

    use \Zend\ServiceManager\ServiceLocatorAwareTrait;

    public function createMessage(array $postData)
    {
        $form = $this->getServiceLocator()->get('HtMessaging\MessageForm');
        $messageClass = $this->getOptions()->getMessageEntityClass();
        $message = new $messageClass;
        $form->bind($message);
        $postData['sender_id'] = $this->getServiceLocator()->get('zfcuser_auth_service')->getIdentity()->getId();
        $form->setData($postData);
        if (!$form->isValid()) {
            return false;
        }

        $receivers = (array) $postData['receiver_id'];

        if (!$this->getOptions()->getEnableMultipleReceivers() && count($receivers) > 1) {
            return false;
        }

        $message = $form->getData();

        $this->getEventManager()->trigger(__FUNCTION__, $this, array('message' => $message, 'form' => $form));
        $this->getMessageMapper()->insert($message);
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('message' => $message, 'form' => $form));
        
        $this->addReceipents($message, $receivers);
    
        return true;        
    }


    public function addReceipents(MessageInterface $message, array $receiverIds)
    {
        $receivers = $this->getServiceLocator()->get('htmessaging_user_mapper')->fetchAll(null, function(Select $select) use ($receiverIds) {
            $select->where(array('user_id' => $receiverIds));
        });

        if ($this->getOptions()->getSendEmailMessage()) {
            $emailSender = $this->getServiceLocator()->get('HtMessaging\Service\EmailSender');
            $this->getEventManager()->attach($emailSender);
        }

        foreach ($receivers as $receiver) {
            $this->sendMessage($message, $receiver);
        }

        return true;        
    }

    protected  function sendMessage(MessageInterface $message, UserInterface $receiver)
    {
        $messageReceiverEntityClass = $this->getOptions()->getMessageReceiverEntityClass();
        $messageReceiver = new $messageReceiverEntityClass;
        $messageReceiver->setMessageId($message->getId());
        $messageReceiver->setReceiverId($receiver->getId());
        $this->getEventManager()->trigger(__FUNCTION__, $this, array('messageReceiver' => $messageReceiver, 'message' => $message, 'receiver' => $receiver));
        $this->getMessageReceiverMapper()->insert($messageReceiver);
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('messageReceiver' => $messageReceiver, 'message' => $message, 'receiver' => $receiver));
    }


    /**
     * gets module options from ServiceManager
     *
     * @return \HtMessaging\Options\ModuleOptions
     */
    protected function getOptions()
    {
        if (!$this->moduleOptions) {
            $this->moduleOptions = $this->getServiceLocator()->get('HtMessaging\ModuleOptions');
        }

        return $this->moduleOptions;
    }

    protected function getMessageMapper()
    {
        if (!$this->messageMapper) {
            $this->messageMapper = $this->getServiceLocator()->get('HtMessaging\MessageMapper');
        }

        return $this->messageMapper;
    }

    protected function getMessageReceiverMapper()
    {
        if (!$this->messageReceiverMapper) {
            $this->messageReceiverMapper = $this->getServiceLocator()->get('HtMessaging\MessageReceiverMapper');
        }
        
        return $this->messageReceiverMapper;         
    }
}
