<?php
namespace HtMessaging;

use Zend\Mvc\MvcEvent;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {

        $sm = $e->getApplication()->getServiceManager();
        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', MvcEvent::EVENT_DISPATCH, function($e) use ($sm) {
            $controller      = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            if ($moduleNamespace === __NAMESPACE__ && !$sm->get('zfcuser_auth_service')->hasIdentity()) {
                return $controller->plugin("redirect")->toRoute($sm->get('HtMessaging\ModuleOptions')->getLoginRoute());
            }
        }, 100); 
    }

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
                'HtMessaging\MessageForm' => 'HtMessaging\Service\MessageFormFactory',
                'HtMessaging\MessageMapper' => function ($sm) {
                    $options = $sm->get('HtMessaging\ModuleOptions');
                    $mapper = new Mapper\MessageMapper();
                    $mapper->setDbAdapter($sm->get('HtMessaging\DbAdapter'));
                    $entityClass = $options->getMessageEntityClass();
                    $mapper->setEntityPrototype(new $entityClass);
                    $mapper->setHydrator(new Mapper\MessageHydrator);
                    return $mapper;
                },
                'HtMessaging\MessageReceiverMapper' => function ($sm) {
                    $options = $sm->get('HtMessaging\ModuleOptions');
                    $mapper = new Mapper\MessageReceiverMapper();
                    $mapper->setDbAdapter($sm->get('HtMessaging\DbAdapter'));
                    $entityClass = $options->getMessageReceiverEntityClass();
                    $mapper->setEntityPrototype(new $entityClass);
                    $mapper->setHydrator(new Mapper\MessageReceiverHydrator);
                    return $mapper;
                },
                'htmessaging_user_mapper' => function ($sm) {
                    $zfcuserOptions = $sm->get('zfcuser_module_options');
                    $mapper = new Mapper\UserMapper();
                    $mapper->setDbAdapter($sm->get('HtMessaging\DbAdapter'));
                    $entityClass = $zfcuserOptions->getUserEntityClass();
                    $mapper->setEntityPrototype(new $entityClass);
                    $mapper->setHydrator(new \ZfcUser\Mapper\UserHydrator());
                    $mapper->setTableName($zfcuserOptions->getTableName());
                    $mapper->setCurrentUser($sm->get('zfcuser_auth_service')->getIdentity());
                    return $mapper;
                },
                'HtMessaging\Service\EmailSender' => function ($sm) {
                    $emailSender = new Service\EmailSender();
                    return $emailSender;
                },
                'HtMessaging\Service\MessagingService' => function ($sm) {
                    $service = new Service\MessagingService();
                    $service->setServiceLocator($sm);
                    return $service;
                }
            )
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'htMessagingOptions' => function ($sm) {
                    $helper = new View\Helper\ModuleOptions();
                    $helper->setOptions($sm->getServiceLocator()->get('HtMessaging\ModuleOptions'));
                    return $helper;
                },
                'htmessagingComparer' => function($sm) {
                    $helper = new View\Helper\Comparer();
                    return $helper;
                },
                'htSmartTime' => function($sm) {
                    return new View\Helper\SmartTime;
                }
            )
        );
    }
}
