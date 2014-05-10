<?php

namespace HtMessaging\Service;

use Zend\Navigation\Service\DefaultNavigationFactory;

class HtMessagingNavigationFactory extends DefaultNavigationFactory
{
    protected function getName()
    {
        return 'HtMessaging';
    }
}