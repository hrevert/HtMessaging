<?php

namespace HtMessaging\View\Helper;

use Zend\View\Helper\AbstractHelper;
use ArrayObject;
use HtMessaging\Entity\Message;
use HtMessaging\Entity\MessageReceiver;

class Comparer extends AbstractHelper
{
    public function isReceived(ArrayObject $message)
    {
        return $message->received_or_not === MessageReceiver::RECEIVED;
    }

    public function isStarred(ArrayObject $message)
    {
        return $message->starred_or_not === MessageReceiver::STARRED;
    }

    public function isImportant(ArrayObject $message)
    {
        return $message->important_or_not === MessageReceiver::IMPORTANT;
    }
}
