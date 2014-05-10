<?php

return array(
    'factories' => array(
        'HtMessaging\ModuleOptions' => 'HtMessaging\Factory\ModuleOptionsFactory',
        'HtMessaging\MessageForm' => 'HtMessaging\Factory\MessageFormFactory',
        'HtMessaging\MessageMapper' => 'HtMessaging\Factory\MessageMapperFactory',
        'HtMessaging\MessageReceiverMapper' => 'HtMessaging\Factory\MessageReceiverMapperFactory',
        'htmessaging_user_mapper' => 'HtMessaging\Factory\UserMapperFactory',
        'HtMessaging\Service\MessagingService' => 'HtMessaging\Factory\MessagingServiceFactory',
        'HtMessaging_navigation' => 'HtMessaging\Service\HtMessagingNavigationFactory',
    ),
    'invokables' => array(
        'HtMessaging\Service\EmailSender' => 'HtMessaging\Service\EmailSender',
    )
);