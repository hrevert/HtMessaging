<?php
namespace HtMessaging;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'HtMessaging\ModuleOptions' => function ($sm) {
                    $config = $sm->get('config');
                    $moduleConfig = isset($config['htmessaging']) ? $config['htmessaging'] : array();
                    return new Options\ModuleOptions($moduleConfig);
                },
                'HtMessaging\MessageForm' => function ($sm) {
                    $form = new Form\MessageForm($sm->get('HtMessaging\ModuleOptions'));
                    return $form;
                },
                'HtMessaging\MessageMapper' => function ($sm) {
                    $options = $sm->get('HtMessaging\ModuleOptions');
                    $mapper = new Mapper\MessageMapper();
                    $mapper->setDbAdapter($sm->get('HtMessaging\DbAdapter'));
                    $entityClass = $options->getMessageEntityClass();
                    $mapper->setEntityPrototype(new $entityClass);
                    return $mapper;
                },
                'HtMessaging\MessageReceiverMapper' => function ($sm) {
                    $options = $sm->get('HtMessaging\ModuleOptions');
                    $mapper = new Mapper\MessageReceiverMapper();
                    $mapper->setDbAdapter($sm->get('HtMessaging\DbAdapter'));
                    $entityClass = $options->getMessageReceiverEntityClass();
                    $mapper->setEntityPrototype(new $entityClass);
                    return $mapper;
                },
            )
        );
    }
}
