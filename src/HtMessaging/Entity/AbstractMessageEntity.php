<?php
    
namespace HtMessaging\Entity;

abstract class AbstractMessageEntity
{
    const STARRED = 1;

    const NOT_STARRED = 0;

    const IMPORTANT = 1;

    const NOT_IMPORTANT = 0;

    protected $id;

    protected $starredOrNot = self::NOT_STARRED;

    protected $importantOrNot = self::NOT_IMPORTANT;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setStarredOrNot($starredOrNot)
    {
        $this->starredOrNot = $starredOrNot;
    }

    public function setStarred()
    {
        $this->setStarredOrNot(static::STARRED);
    }

    public function setUnstarred()
    {
        $this->setStarredOrNot(static::NOT_STARRED);
    }

    public function getStarredOrNot()
    {
        return $this->starredOrNot;
    }

    public function isStarred()
    {
        return $this->getStarredOrNot() === static::STARRED;
    }

    public function setImportantOrNot($importantOrNot)
    {
        $this->importantOrNot = $importantOrNot;
    }

    public function setImportant()
    {
        $this->setImportantOrNot(static::IMPORTANT);
    }

    public function setUnimportant()
    {
        $this->setImportantOrNot(static::NOT_IMPORTANT);
    }

    public function getImportantOrNot()
    {
        return $this->importantOrNot;
    }

    public function isImportant()
    {
        return $this->getImportantOrNot() === static::IMPORTANT;
    }
}
