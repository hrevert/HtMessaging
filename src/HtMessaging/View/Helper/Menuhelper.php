<?php
namespace HtMessaging\View\Helper;
use Zend\View\Helper\AbstractHelper;

class Menuhelper extends AbstractHelper
{
    public function __invoke()
    {
        if ($this->getView()->showMenu === true){
            $message = "<h2>Menu</h2> " .
            $this->getView()->navigation('HtMessaging_navigation')->menu() . "
            <br />
            <br />";

            return $message;
        }
    }
}