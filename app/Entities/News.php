<?php

namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="NULL")
 */
class News
{
    /**
     * @param $title
     * @param $text
     * @param $created_at
     * @param $updated_at
     */
    public function __construct($title, $text, $created_at, $updated_at)
    {
        $this->title = $title;
        $this->text  = $text;
        $this->created_at  = $created_at;
        $this->updated_at  = $updated_at;
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    public $title;

    /**
     * @ORM\Column(type="string")
     */
    public $text;

    /**
     * @ORM\Column(type="date")
     */
    public $created_at;

    /**
     * @ORM\Column(type="date")
     */
    public $updated_at;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function toArray() {
        return get_object_vars($this);
    }
}
