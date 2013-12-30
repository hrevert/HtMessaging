<?php
    
namespace HtMessaging\Mapper;

use Zend\Db\Sql\Expression as SqlExpression;
use ZfcUser\Entity\UserInterface;
use Zend\Db\Sql\Select;

class UserMapper extends \ZfcUser\Mapper\User
{
    /**
     * @var UserInterface           Currently logged in user
     */
    protected $currentUser;


    /**
     * sets Currently logged in user
     *
     * @param UserInterface $currentUser
     * @return void 
     */
    public function setCurrentUser(UserInterface $currentUser)
    {
        $this->currentUser = $currentUser;
    }

    /**
     * gets Currently logged in user
     *
     * @return UserInterface $currentUser
     */
    public function getCurrentUser()
    {
        return $this->currentUser;
    }

    /**
     * gets users list
     *
     * @param array $columns         columns to fetch from user table
     * @param Closure $Closure       to manipulate Select
     * @return \Zend\Db\ResultSet\ResultSet 
     */
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

    /**
     * gets users list for Select form element
     *
     * @return array
     */
    public function getSelectOptions()
    {
        $resultSet =  $this->fetchAll(array('user_id', 'display_name'), function(Select $select) {
            $select->where->notEqualTo('user_id', $this->getCurrentUser()->getId());
        });

        $options = array();
        foreach ($resultSet as $user) {
            $options[$user->getId()] = $user->getDisplayName();
        }

        return $options;
    }
                
}
