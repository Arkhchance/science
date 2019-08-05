<?php
namespace Science\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
* Pays
*
* @ORM\Table(name="messages")
* @ORM\Entity
*/
class Messages
{
    /**
    * @var int
    *
    * @ORM\Column(name="id", type="integer", nullable=false)
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="IDENTITY")
    */
    private $id;

    /**
    * @var string|null
    *
    * @ORM\Column(name="message", type="text", length=65535, nullable=false)
    */
    private $message;

    /**
    * Get id.
    *
    * @return string
    */
    public function getId()
    {
        return $this->id;
    }

    /**
    * Set Message.
    *
    * @param string $message
    *
    * @return Pays
    */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
    * Get Message.
    *
    * @return string
    */
    public function getMessage()
    {
        return $this->message;
    }

}
