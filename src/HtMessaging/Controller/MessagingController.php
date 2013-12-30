<?php
    
namespace HtMessaging\Controller;

class MessagingController
{
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
                $messages = $this->getMessageMapper()->findMessagesBySenderId($user->getId(), true);
                break;
            default:
                return $this->notFoundAction();
        }

        $messages->setItemCountPerPage(self::NUM_OF_MSG_PER_PAGE);
        $messages->setCurrentPageNumber($this->params()->fromRoute('page', 1));

        return new ViewModel(array(
            'messages' => $messages,
            'type' => $type
        ));
    }

    public function inboxAction()
    {
        
    }

    public function sentAction()
    {
        
    }

    public function starredAction()
    {
        
    }

    public function importantAction()
    {
        
    }

    public function addReceiverAction()
    {
        
    }

    public function receiversAction()
    {
        
    }

    public function deleteAction()
    {
        $options = $this->getModuleOptions();

        if (!$options->getAllowDeleteMessage()) {
            return $this->notFoundAction();
        }
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
}
