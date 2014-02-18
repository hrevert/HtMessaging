<?php

namespace HtMessaging\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use HtMessaging\Mapper\UserMapper;

class UserMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $zfcuserOptions = $serviceLocator->get('zfcuser_module_options');
        $mapper = new UserMapper();
        $mapper->setDbAdapter($serviceLocator->get('HtMessaging\DbAdapter'));
        $entityClass = $zfcuserOptions->getUserEntityClass();
        $mapper->setEntityPrototype(new $entityClass);
        $mapper->setHydrator(new \ZfcUser\Mapper\UserHydrator());
        $mapper->setTableName($zfcuserOptions->getTableName());
        $mapper->setCurrentUser($serviceLocator->get('zfcuser_auth_service')->getIdentity());

        return $mapper;        
    }
}
