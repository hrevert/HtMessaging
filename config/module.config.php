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
                            'route' => '/:type[/][page/:page[/]]',
                        ),
                        'defaults' => array(
                            'type' => 'inbox',
                            'page' => 1
                        )
                    ),
                    'compose' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/compose',
                            'defaults' => array(
                                'action' => 'compose'
                            )
                        )                        
                    ),
                    'info' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/info/:message_id',
                            'defaults' => array(
                                'action' => 'info'
                            )
                        )                        
                    ),
                    'sent_info' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/sent-info/:message_id[/]',
                            'defaults' => array(
                                'controller' => 'htmessaging',
                                'action' => 'sent-info'
                            )
                        )                        
                    ),
                    'add-receiver' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/add-receiver:message_id[/]',
                            'defaults' => array(
                                'action' => 'add-receiver'
                            )
                        )                    
                    ),
                    'receivers' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/receivers:message_id[/]',
                            'defaults' => array(
                                'action' => 'receivers'
                            )
                        )                    
                    ),
                    'delete_receiver' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/delete-receiver/:id[/]',
                            'defaults' => array(
                                'action' => 'delete'
                            )
                        )                    
                    ),
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
