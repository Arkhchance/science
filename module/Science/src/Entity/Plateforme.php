<?php
namespace Science\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Science\Entity\Vulga;
use Science\Entity\MainStats;
use Science\Entity\Posts;

/**
* Plateforme
*
* @ORM\Table(name="plateforme")
* @ORM\Entity
*/
class Plateforme
{
    /**
    * @ORM\OneToMany(targetEntity="\Science\Entity\Posts", mappedBy="plateforme")
    * @ORM\JoinColumn(name="id", referencedColumnName="plateforme")
    */
    protected $posts;

    /**
    * @ORM\OneToMany(targetEntity="\Science\Entity\MainStats", mappedBy="plateforme")
    * @ORM\JoinColumn(name="id", referencedColumnName="plateforme")
    */
    protected $mainstats;

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
    * @ORM\Column(name="nom", type="string", length=128, nullable=false)
    */
    private $nom;

    /**
    * @var string
    *
    * @ORM\Column(name="address", type="string", length=128, nullable=false)
    */
    private $address;

    /**
    * @var string
    *
    * @ORM\Column(name="post_name", type="string", length=255, nullable=false)
    */
    private $postName;

    /**
    * @var string
    *
    * @ORM\Column(name="id_extract_pattern", type="string", length=512, nullable=false)
    */
    private $idExtractPattern;

    /**
    * @ORM\ManyToMany(targetEntity="\Science\Entity\Vulga", mappedBy="plateforme")
    */
    protected $vulga;

    /**
    * Constructor.
    */
    public function __construct()
    {
        $this->vulga = new ArrayCollection();
        $this->mainstats = new ArrayCollection();
        $this->posts = new ArrayCollection();
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
        $vulga->removePlateforme($this);
    }

    /**
    * Returns mainstats for this plateforme.
    * @return array
    */
    public function getMainstats()
    {
        return $this->mainstats;
    }

    /**
    * Adds a mainstats to this plateforme.
    * @param $mainstats
    */
    public function addMainstats($mainstats)
    {
        $this->mainstats[] = $mainstats;
    }

    /**
    * Returns post for this plateforme.
    * @return array
    */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
    * Adds a posts to this plateforme.
    * @param $mainstats
    */
    public function addPosts($posts)
    {
        $this->posts[] = $posts;
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
    * @return Plateforme
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
    * Set address.
    *
    * @param string $address
    *
    * @return Plateforme
    */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
    * Get address.
    *
    * @return string
    */
    public function getAddress()
    {
        return $this->address;
    }

    /**
    * Set postName.
    *
    * @param string $postName
    *
    * @return Plateforme
    */
    public function setPostName($postName)
    {
        $this->postName = $postName;

        return $this;
    }

    /**
    * Get postName.
    *
    * @return string
    */
    public function getPostName()
    {
        return $this->postName;
    }

    /**
    * Set idExtractPattern.
    *
    * @param string $idExtractPattern
    *
    * @return Plateforme
    */
    public function setIdExtractPattern($idExtractPattern)
    {
        $this->idExtractPattern = $idExtractPattern;

        return $this;
    }

    /**
    * Get idExtractPattern.
    *
    * @return string
    */
    public function getIdExtractPattern()
    {
        return $this->idExtractPattern;
    }
}
