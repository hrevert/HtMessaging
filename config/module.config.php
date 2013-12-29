<?php
return array(
    'service_manager' => array(
        'aliases' => array(
            'HtMessaging\DbAdapter' => 'Zend\Db\Adapter\Adapter'
        )
    ),
    'controller' => array(
        'invokables' => array(
        
        )
    ),
    'router' => array(
        'routes' => array(
            'htmessaging' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/messaging',
                    'defaults' => array(
                    
                    )
                ),
                'may_termainate' => true,
                'child_routes' => array(
                
                )
            )
        )
    )

);
