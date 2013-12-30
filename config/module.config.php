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
            'HtMessaging\DbAdapter' => 'zfcuser_zend_db_adapter'
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'htmessaging' => 'HtMessaging\Controller\MessagingController',
        )
    ),
    'router' => array(
        'routes' => array(
            'htmessaging' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/messaging',
                    'defaults' => array(
                        'controller' => 'htmessaging',
                        'action' => 'list'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'list' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:type[/]]',
                        )
                    ),
                    'compose' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/compose',
                            'defaults' => array(
                                'controller' => 'htmessaging',
                                'action' => 'compose'
                            )
                        )                        
                    )
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
