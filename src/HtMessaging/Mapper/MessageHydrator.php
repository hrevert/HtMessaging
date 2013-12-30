<?php
    
namespace HtMessaging\Mapper;

use Zend\Stdlib\Hydrator\ClassMethods;
use HtMessaging\Entity\MessageInterface;

class MessageHydrator extends ClassMethods
{
    /**
     * Extract MessageInterface from an object
     *
     * @param  object $object
     * @return array
     * @throws \InvalidArgumentException
     */
    public function extract($object)
    {
        if (!$object instanceof MessageInterface) {
            throw new \InvalidArgumentException('$object must be an instance of HtMessaging\Entity\MessageInterface');
        }
        $data = parent::extract($object);
        unset($data['is_starred']);
        unset($data['is_important']);

        return $data;
    }    
}
