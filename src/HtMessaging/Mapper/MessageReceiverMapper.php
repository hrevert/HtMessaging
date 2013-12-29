<?php
    
namespace HtProfileImage\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use HtProfileImage\Entity\MessageInterface;
use HtProfileImage\Entity\MessageReceiverInterface;
use ZfcUser\Entity\UserInterface;
use Zend\Db\Sql\Expression as SqlExpression;
use Zend\Db\Sql\Select;
use ArrayObject;
use Zend\Stdlib\Hydrator\ObjectProperty;
use Zend\Stdlib\Hydrator\HydratorInterface;

class MessageReceiverMapper extends AbstractDbMapper
{
    protected $tableName = "message_receiver";

    protected $messageTableName = "message";

    public function getTableName()
    {
        return $this->tableName;
    }
    
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }
    
    public function setMessageTableName($messageTableName)
    {
        $this->messageTableName = $messageTableName;
    }
    
    public function getMessageTableName()
    {
        return $this->messageTableName;
    } 

    public function findByMessageId($messageId)
    {
        $select = $this->getSelect();
        $select->where(array('message_id' => $messageId));

        return $this->select($select);        
    }

    public function findByMessage(MessageInterface $message)
    {
        return $this->findByMessageId($message->getId());
    }

    public function findByReceiverId($receiverId)
    {
        $select = $this->getSelect();
        $select->where(array('receiver_id' => $receiverId));
        $this->joinWithMessage($select);

        return $this->select($select, new ArrayObject, new ObjectProperty);
    }


    public function findByReceiver(UserInterface $receiver)
    {
        return $this->findByReceiverId($receiver->getId());
    }


    public function findByReceiverIdAndMessageId($messageId, $receiverId)
    {
        $select = $this->getSelect();
        $select->where(array('receiver_id' => $receiverId, 'message_id' => $messageId));
        $this->joinWithMessage($select);

        return $this->select($select, new ArrayObject, new ObjectProperty)->current();        
    }

    protected function joinWithMessage(Select $select, $columns = array('*'))
    {
        $select->join(
            $this->getMessageTableName(),
            $this->getMessageTableName() . '.id = ' . $this->getTableName() . '.message_id',
            $columns,
            Select::JOIN_INNER 
        );        
    }

    public function insert(MessageReceiverInterface $messageReceiver)
    {
        $messageReceiver->setSentDateTime(new SqlExpression("NOW()"));
        $result = parent::insert($messageReceiver);
        $messageReceiver->setId($result->getGeneratedValue());

        return $result;
    }

    public function update(MessageReceiverInterface $messageReceiver, $where = null, $tableName = null, HydratorInterface $hydrator = null)
    {
        if (!$where) {
            $where = array('id' => $messageReceiver->getId());
        }

        return parent::update($entity, $where, $tableName, $hydrator);

    }
}
