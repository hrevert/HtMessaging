<?php
    
namespace HtMessaging\Controller;

class MessagingController
{

    const NUM_OF_MSG_PER_PAGE = 20;

    /**
     * @var HtMessaging\Mapper\MessageMapper
     */
    protected $messageMapper;

    /**
     * @var HtMessaging\Mapper\MessageReceiverMapper
     */
    protected $messageReceiverMapper;


    public function composeAction()
    {
        $form = $this->getServiceLocator()->get('HtMessaging\MessageForm');

        $request = $this->getRequest();
        if ($request->isPost()) {
            
        }

        return array(
            'form' => $form
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
