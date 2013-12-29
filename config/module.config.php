<?php
return array(
    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                __DIR__ . '/../public',
            ),
        ),
    ),
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
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'HtMessaging' => __DIR__."/../view/"
        )
    )

);
