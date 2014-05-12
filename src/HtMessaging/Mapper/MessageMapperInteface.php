<?php

namespace HtMessaging\Mapper;

use ZfcUser\Entity\UserInterface;
use HtMessaging\Entity\MessageInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;

interface MessageMapperInteface
{
    public function findById($messageId);

    public function findBySenderId($senderId, $paginated = false);

    public function insert($message, $tablename = null, HydratorInterface $hydrator = null);

    public function update($message, $where = null, $tableName = null, HydratorInterface $hydrator = null);

}
