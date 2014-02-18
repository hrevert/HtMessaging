<?php

namespace HtMessaging\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use HtMessaging\Options\ModuleOptions;

class ModuleOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $moduleConfig = isset($config['htmessaging']) ? $config['htmessaging'] : array();
        return new ModuleOptions($moduleConfig);        
    }
}
