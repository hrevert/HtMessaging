<?php

namespace HtMessaging\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HtMessaging\Form\MessageForm;
use HtMessaging\Form\MessageInputFilter;

class MessageFormFactory implements FactoryInterface
{

    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * instantiates MessageForm and injects dependancies
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param MessageForm
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $options = $serviceLocator->get('HtMessaging\ModuleOptions');
        $form = new MessageForm($options);
        $form->init();
        $form->get('receiver_id')->setValueOptions($this->getUserOptions());
        $form->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods());
        $inputFilter = new MessageInputFilter($options);
        $inputFilter->init();
        $form->setInputFilter($inputFilter);
        return $form;        
    }

    /**
     * gets ServiceLocator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    
    /**
     * gets user options for select value options
     *
     * @return array
     */
    protected function getUserOptions()
    {
        return $this->getServiceLocator()->get('htmessaging_user_mapper')->getSelectOptions();
    }
}
