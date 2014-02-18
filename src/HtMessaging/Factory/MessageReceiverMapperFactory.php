<?php

namespace HtMessaging\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use HtMessaging\Mapper\MessageReceiverMapper;
use HtMessaging\Stdlib\Hydrator\MessageReceiverHydrator;

class MessageReceiverMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('HtMessaging\ModuleOptions');
        $mapper = new MessageReceiverMapper();
        $mapper->setDbAdapter($serviceLocator->get('HtMessaging\DbAdapter'));
        $entityClass = $options->getMessageReceiverEntityClass();
        $mapper->setEntityPrototype(new $entityClass);
        $mapper->setHydrator(new MessageReceiverHydrator);

        return $mapper;        
    }   
}
