<?php
namespace Science\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a registered user.
 * @ORM\Entity
 * @ORM\Table(name="regkey")
 */
class Regkey
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="reg_key")
     */
    protected $key;

    /**
     * @ORM\Column(name="creation_date")
     */
    protected $date;

    /**
     * Returns user ID.
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns key.
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Sets key.
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Returns creation date.
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets date.
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

}
