<?php

namespace HtMessaging\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use HtMessaging\Service\MessagingService;

class MessagingServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new MessagingService();
        $service->setServiceLocator($serviceLocator);
        return $service;        
    }
}
