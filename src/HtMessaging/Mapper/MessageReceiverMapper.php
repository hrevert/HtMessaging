<?php
    
namespace HtMessaging\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use HtMessaging\Entity\MessageInterface;
use HtMessaging\Entity\MessageReceiverInterface;
use HtMessaging\Entity\MessageReceiver;
use Zend\Db\Sql\Expression as SqlExpression;
use Zend\Db\Sql\Select;
use ArrayObject;
use Zend\Stdlib\Hydrator\ObjectProperty;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class MessageReceiverMapper extends AbstractDbMapper implements MessageReceiverMapperInterface
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
    
    public function findById($id)
    {
        $select = $this->getSelect();
        $select->where(array('id' => $id));

        return $this->select($select)->current();        
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

    public function findByReceiverId($receiverId, $paginated = false)
    {
        $select = $this->getSelect();
        $select->where(array('receiver_id' => $receiverId));
        $this->joinWithMessage($select);

        if ($paginated) {
            return new Paginator(new DbSelect($select, $this->getDbAdapter()));
        }

        return $this->select($select, new ArrayObject, new ObjectProperty);
    }

    public function findStarredMessagesByReceiverId($receiverId, $paginated = false)
    {
        $select = $this->getSelect();
        $select->where(array('receiver_id' => $receiverId, 'starred_or_not' => MessageReceiver::STARRED));
        $this->joinWithMessage($select);

        if ($paginated) {
            return new Paginator(new DbSelect($select, $this->getDbAdapter()));
        }

        return $this->select($select, new ArrayObject, new ObjectProperty);        
    }

    public function findImportantMessagesByReceiverId($receiverId, $paginated = false)
    {
        $select = $this->getSelect();
        $select->where(array('receiver_id' => $receiverId, 'important_or_not' => MessageReceiver::IMPORTANT));
        $this->joinWithMessage($select);

        if ($paginated) {
            return new Paginator(new DbSelect($select, $this->getDbAdapter()));
        }

        return $this->select($select, new ArrayObject, new ObjectProperty);          
    }


    public function findUnreadMessagesByReceiverId($receiverId, $paginated = false)
    {
        $select = $this->getSelect();
        $select->where(array('receiver_id' => $receiverId, 'received_or_not' => MessageReceiver::NOT_RECEIVED));
        $this->joinWithMessage($select);
        if ($paginated) {
            return new Paginator(new DbSelect($select, $this->getDbAdapter()));
        }

        return $this->select($select, new ArrayObject, new ObjectProperty);          
    }


    public function findByReceiverIdAndMessageId($messageId, $receiverId, $joinWithMessage = false)
    {
        $select = $this->getSelect();
        $select->where(array('receiver_id' => $receiverId, 'message_id' => $messageId));
        if ($joinWithMessage) {
            $this->joinWithMessage($select);
            return $this->select($select, new ArrayObject, new ObjectProperty)->current();              
        }
         return $this->select($select)->current();      
    }

    protected function joinWithMessage(Select $select, $columns = array('sender_id', 'subject'))
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

        return parent::update($messageReceiver, $where, $tableName, $hydrator);

    }

    public function deleteById($id) 
    {
        return parent::delete(array('id' => $id));
    }

    public function delete(MessageReceiverInterface $messageReceiver)
    {
        return $this->deleteById($messageReceiver->getId());
    }

}
