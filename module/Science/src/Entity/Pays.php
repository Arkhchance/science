<?php
namespace Science\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Science\Entity\Vulga;

/**
* Pays
*
* @ORM\Table(name="pays")
* @ORM\Entity(repositoryClass="\Science\Repository\PaysRepository")
*/
class Pays
{
    /**
    * @ORM\OneToMany(targetEntity="\Science\Entity\Vulga", mappedBy="pays")
    * @ORM\JoinColumn(name="id", referencedColumnName="pays")
    */
    protected $vulga;

    /**
    * @var int
    *
    * @ORM\Column(name="id", type="integer", nullable=false)
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="IDENTITY")
    */
    private $id;

    /**
    * @var string
    *
    * @ORM\Column(name="nom", type="string", length=100, nullable=false)
    */
    private $nom;

    /**
    * @var string
    *
    * @ORM\Column(name="code", type="string", length=10, nullable=false)
    */
    private $code;

    /**
    * @var string
    *
    * @ORM\Column(name="drapeau", type="string", length=5, nullable=false)
    */
    private $drapeau;

    /**
    * Constructor.
    */
    public function __construct()
    {
        $this->vulga = new ArrayCollection();
    }

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
    * Set nom.
    *
    * @param string $nom
    *
    * @return Pays
    */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
    * Get nom.
    *
    * @return string
    */
    public function getNom()
    {
        return $this->nom;
    }

    /**
    * Set code.
    *
    * @param string $code
    *
    * @return Pays
    */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
    * Get code.
    *
    * @return string
    */
    public function getCode()
    {
        return $this->code;
    }

    /**
    * Returns vulga for this Pays.
    * @return array
    */
    public function getVulga()
    {
        return $this->vulga;
    }

    /**
    * Adds a vulga to this Pays.
    * @param $vulga
    */
    public function addVulga($vulga)
    {
        $this->vulga[] = $vulga;
    }

    /**
    * Set drapeau.
    *
    * @param string $drapeau
    *
    * @return Pays
    */
    public function setDrapeau($drapeau)
    {
        $this->drapeau = $drapeau;

        return $this;
    }

    /**
    * Get drapeau.
    *
    * @return string
    */
    public function getDrapeau()
    {
        return $this->drapeau;
    }

}
