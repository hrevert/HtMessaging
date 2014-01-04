<?php

namespace HtMessaging\Mapper;

use ZfcUser\Entity\UserInterface;
use HtMessaging\Entity\MessageInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;

interface MessageMapperInteface
{
    public function findById($messageId);

    public function findBySenderId($senderId, $paginated = false);

    public function insert(MessageInterface $message);

    public function update(MessageInterface $message, $where = null, $tableName = null, HydratorInterface $hydrator = null);

}
