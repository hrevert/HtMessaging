<?php

namespace HtMessaging\View\Helper;

use Zend\View\Helper\AbstractHelper;

class ModuleOptions extends AbstractHelper
{
    protected $options;

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions($options)
    {
        $this->options = $options;
    }

    public function getAllowDeleteMessage()
    {
        return $this->getOptions()->getAllowDeleteMessage();
    }

    public function getEnableMultipleReceivers()
    {
        return $this->getOptions()->getEnableMultipleReceivers();
    }
}