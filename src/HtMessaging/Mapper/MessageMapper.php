<?php
    
namespace HtProfileImage\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use HtProfileImage\Entity\MessageInterface;
use ZfcUser\Entity\UserInterface;
use Zend\Db\Sql\Expression as SqlExpression;

class MessageMapper extends AbstractDbMapper
{
    protected $tableName = "message";

    public function findById($messageId)
    {
        $select = $this->getSelect();
        $select->where(array('id' => $messageId));
        return $this->select($select)->current();
    }

    public function findBySenderId($senderId)
    {
        $select = $this->getSelect();
        $select->where(array('sender_id' => $senderId));
        return $this->select($select);
    }

    public function findBySender(UserInterface $sender)
    {
        return $this->findBySenderId($sender->getId());
    }

    public function insert(MessageInterface $message)
    {
        $message->setCreatedDateTime(new SqlExpression("NOW()"));
        $result = parent::insert($message);
        $message->setId($result->getGeneratedValue());
        return $result;
    }

    public function getTableName()
    {
        return $this->tableName;
    }
    
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    } 
}
