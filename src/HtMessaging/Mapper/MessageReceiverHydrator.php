<?php

namespace HtMessaging\Mapper;

use Zend\Stdlib\Hydrator\ClassMethods;
use HtMessaging\Entity\MessageReceiverInterface;

class MessageReceiverHydrator extends ClassMethods
{

    /**
     * Extract MessageReceiverInterface from an object
     *
     * @param  object $object
     * @return array
     * @throws \InvalidArgumentException
     */
    public function extract($object)
    {
        if (!$object instanceof MessageReceiverInterface) {
            throw new \InvalidArgumentException('$object must be an instance of HtMessaging\Entity\MessageReceiverInterface');
        }
        $data = parent::extract($object);
        unset($data['is_received']);
        unset($data['is_starred']);
        unset($data['is_important']);

        return $data;
    }
}
