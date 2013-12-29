<?php
namespace HtMessaging;

use Zend\Mvc\MvcEvent;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', 'dispatch', function($e) use ($sm) {
            $controller = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            if ($moduleNamespace === __NAMESPACE__) {
                if (!$sm->get('zfcuser_auth_service')->hasIdentity()) {
                    return $controller->plugin("redirect")->toRoute($sm->get('HtMessaging\ModuleOptions')->getLoginRoute());
                }
            }
        }); 
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
