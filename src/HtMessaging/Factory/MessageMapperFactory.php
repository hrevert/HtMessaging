<?php
    
namespace HtMessaging\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use HtMessaging\Mapper\MessageMapper;
use HtMessaging\Stdlib\Hydrator\MessageHydrator;

class MessageMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('HtMessaging\ModuleOptions');
        $mapper = new MessageMapper();
        $mapper->setDbAdapter($serviceLocator->get('HtMessaging\DbAdapter'));
        $entityClass = $options->getMessageEntityClass();
        $mapper->setEntityPrototype(new $entityClass);
        $mapper->setHydrator(new MessageHydrator);

        return $mapper;        
    }
}
