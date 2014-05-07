<?php

return array(
    'factories' => array(
        'HtMessaging\ModuleOptions' => 'HtMessaging\Factory\ModuleOptionsFactory',
        'HtMessaging\MessageForm' => 'HtMessaging\Service\MessageFormFactory',
        'HtMessaging\MessageMapper' => 'HtMessaging\Factory\MessageMapperFactory',
        'HtMessaging\MessageReceiverMapper' => 'HtMessaging\Factory\MessageReceiverMapperFactory',
        'htmessaging_user_mapper' => 'HtMessaging\Factory\UserMapperFactory',
        'HtMessaging\Service\MessagingService' => 'HtMessaging\Factory\MessagingServiceFactory',
    ),
    'invokables' => array(
        'HtMessaging\Service\EmailSender' => 'HtMessaging\Service\EmailSender',
    )
);