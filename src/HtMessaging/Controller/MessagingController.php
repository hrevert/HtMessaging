<?php
    
namespace HtMessaging\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MessagingController extends AbstractActionController
{

    const ROUTE_MESSAGING = "htmessaging";

    /**
     * Number of messages per page to show in view templates
     */
    const NUM_OF_MSG_PER_PAGE = 20;

    /**
     * @var HtMessaging\Mapper\MessageMapper
     */
    protected $messageMapper;

    /**
     * @var HtMessaging\Mapper\MessageReceiverMapper
     */
    protected $messageReceiverMapper;

    /**
     * @var HtMessaging\Options\ModuleOptions
     */
    protected $moduleOptions;

    /**
     *@var HtMessaging\Service\MessagingService
     */
    protected $messagingService;

    /**
     * @var HtMessaging\Mapper\UserMapper
     */
    protected $userMapper;


    public function composeAction()
    {
        $form = $this->getServiceLocator()->get('HtMessaging\MessageForm');

        $messageSent = false;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData = $request->getPost()->toArray();
            if ($this->getMessagingService()->createMessage($postData)) {
                $messageSent = true;
            }
        }

        return array(
            'form' => $form,
            'messageSent' => $messageSent
        );
    }

    public function listAction()
    {
        $user = $this->getServiceLocator()->get('zfcuser_auth_service')->getIdentity();

        $type = $this->params()->fromRoute('type', 'inbox');

        $viewModel = new ViewModel(array(
            'type' => $type
        ));

        switch ($type)
        {
            case 'inbox':
                $messages = $this->getMessageReceiverMapper()->findByReceiverId($user->getId(), true);
                break;
            case "starred":
                $messages = $this->getMessageReceiverMapper()->findStarredMessagesByReceiverId($user->getId(), true);
                break;
            case "important":
                $messages = $this->getMessageReceiverMapper()->findImportantMessagesByReceiverId($user->getId(), true);
                break;
            case "unread":
                $messages = $this->getMessageReceiverMapper()->findUnreadMessagesByReceiverId($user->getId(), true);
                break;
            case "sent":
                $messages = $this->getMessageMapper()->findBySenderId($user->getId(), true);
                $viewModel->setTemplate('ht-messaging/messaging/sent');
                break;
            default:
                return $this->notFoundAction();
        }

        $messages->setItemCountPerPage(self::NUM_OF_MSG_PER_PAGE);
        $messages->setCurrentPageNumber($this->params()->fromRoute('page', 1));

        //echo $messages->getTotalItemCount();

        $viewModel->setVariable('messages', $messages);

        return $viewModel;
    }


    public function addReceiverAction()
    {
        $message_id = $this->params()->fromRoute('message_id', null);
        if (!$message_id) {
            return $this->notFoundAction();
        }

        $message = $this->getMessageMapper()->findById($message_id);

        // if message is not found or the user is not sender(i.e. not allowed to view messages sent by other users)
        if (!$message or $this->getServiceLocator()->get('zfcuser_auth_service')->getIdentity()->getId() !== $message->getSenderId()) {
            return $this->notFoundAction();
        }
    }

    public function receiversAction()
    {
        
    }

    /**
     * this methods show message body of a received message
     */
    public function infoAction()
    {
        /*$message_receiver_id = $this->params()->fromRoute('message_receiver_id', null);

        if (!$message_receiver_id) {
            return $this->notFoundAction();
        }

        $messageReceiver = $this->getMessageReceiverMapper()->findById($message_receiver_id);

        if (!$messageReceiver) {
            return $this->notFoundAction();
        }

        $message_id = $messageReceiver->getMessageId();*/

        $message_id = $this->params()->fromRoute('message_id', null);
        //var_dump($message_id);
        if (!$message_id) {
            return $this->notFoundAction();
        }
        $message = $this->getMessageMapper()->findById($message_id);

        if (!$message) {
            return $this->notFoundAction();
        }
        $receiver = $this->getServiceLocator()->get('zfcuser_auth_service')->getIdentity();

        $messageReceiver = $this->getMessageReceiverMapper()->findByReceiverIdAndMessageId($message_id, $receiver->getId());

        if (!$messageReceiver->isReceived()) {
            $messageReceiver->setReceived();
            $this->getMessageReceiverMapper()->update($messageReceiver);
        }

        $sender =  $this->getServiceLocator()->get('htmessaging_user_mapper')->findById($message->getSenderId());

        return new ViewModel(array(
            'message' => $message,
            'messageReceiver' => $messageReceiver,
            'sender' => $sender
        ));
    }

    /**
     * this methods show message body of a sent message
     */
    public function sentInfoAction()
    {
        $message_id = $this->params()->fromRoute('message_id', null);
        if (!$message_id) {
            return $this->notFoundAction();
        }

        $message = $this->getMessageMapper()->findById($message_id);

        if (!$message) {
            return $this->notFoundAction();
        }
        
        
        $messageReceivers = $this->getMessageReceiverMapper()->findByMessage($message);

        if (count($messageReceivers) === 1) {
            $receiver = $this->getUserMapper()->findById($messageReceivers->current()->getReceiverId());
            return new ViewModel(array(
                'message' => $message,
                'messageReceivers' => $messageReceivers,
                'receiver' => $receiver
            )); 
        }
        
        return new ViewModel(array(
            'message' => $message,
            'messageReceivers' => $messageReceivers
        ));        
    }

    public function deleteAction()
    {
        if (!$this->getModuleOptions()->getAllowDeleteMessage()) {
            return $this->notFoundAction();
        }

        $id = $this->params()->fromRoute('id', null);
        if (!$id) {
            return $this->notFoundAction();
        }

        $messageReceiver = $this->getMessageReceiverMapper()->findById($id);
        if (!$messageReceiver) {
            return $this->notFoundAction();
        }

        $this->getMessageReceiverMapper()->delete($messageReceiver);

        return $this->redirect()->toRoute(static::ROUTE_MESSAGING);
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

    /**
     * gets module options from ServiceManager
     *
     * @return \HtMessaging\Options\ModuleOptions
     */
    protected function getModuleOptions()
    {
        if (!$this->moduleOptions) {
            $this->moduleOptions = $this->getServiceLocator()->get('HtMessaging\ModuleOptions');
        }

        return $this->moduleOptions;
    }


    /**
     * gets Messaging Service
     *
     * @return HtMessaging\Service\MessagingService
     */
    protected function getMessagingService()
    {
        if (!$this->messagingService) {
            $this->messagingService = $this->getServiceLocator()->get('HtMessaging\Service\MessagingService');
        }

        return $this->messagingService;
    }

    /**
     * gets User Mapper
     *
     * @return HtMessaging\Mapper\UserMapper
     */
    protected function getUserMapper()
    {
        if (!$this->userMapper) {
            $this->userMapper = $this->getServiceLocator()->get('zfcuser_user_mapper');
        }

        return $this->userMapper;
    }
}
