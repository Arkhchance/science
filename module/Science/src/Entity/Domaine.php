<?php
namespace Science\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Science\Entity\Vulga;
use Doctrine\ORM\Mapping as ORM;

/**
* Domaine
*
* @ORM\Table(name="domaine")
* @ORM\Entity
*/
class Domaine
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
    * @var string
    *
    * @ORM\Column(name="nom", type="string", length=255, nullable=false)
    */
    private $nom;

    /**
    * @var string
    *
    * @ORM\Column(name="description", type="text", length=65535, nullable=false)
    */
    private $description;

    /**
    * @ORM\ManyToMany(targetEntity="\Science\Entity\Vulga", mappedBy="domaine")
    */
    protected $vulga;

    /**
    * Constructor.
    */
    public function __construct()
    {
        $this->vulga = new ArrayCollection();
    }

    /**
    * Returns vulga for this domains.
    * @return array
    */
    public function getVulga()
    {
        return $this->vulga;
    }

    /**
    * Adds a vulga to this domain.
    * @param $vulga
    */
    public function addVulga($vulga)
    {
        $this->vulga[] = $vulga;
    }

    public function removeVulga($vulga)
    {
        if (!$this->vulga->contains($vulga)) 
            return;

        $this->vulga->removeElement($vulga);
        $vulga->removeDomaine($this);
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
    * @return Domain
    */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
    * Get name.
    *
    * @return string
    */
    public function getNom()
    {
        return $this->nom;
    }

    /**
    * Set desc.
    *
    * @param string $desc
    *
    * @return Domain
    */
    public function setDescription($desc)
    {
        $this->description = $nom;

        return $this;
    }

    /**
    * Get desc.
    *
    * @return string
    */
    public function getDescription()
    {
        return $this->description;
    }
}
