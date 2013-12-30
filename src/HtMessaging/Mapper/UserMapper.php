<?php
    
namespace HtMessaging\Mapper;

use Zend\Db\Sql\Expression as SqlExpression;

class UserMapper extends \ZfcUser\Mapper\User
{
    public function fetchAll($columns = null, \Closure $Closure = null)
    {
        $select = $this->getSelect();
        if ($columns) {
            $select->columns($columns);
        }
        if ($Closure) {
            $Closure($select);
        }
        return $this->select($select);
    }
                
}
