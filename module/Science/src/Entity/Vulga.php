<?php
namespace Science\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Science\Entity\Domaine;
use Science\Entity\MainStats;
use Science\Entity\Langue;
use Science\Entity\Pays;
use Science\Entity\Posts;

/**
* Vulga
*
* @ORM\Table(name="vulga")
* @ORM\Entity(repositoryClass="\Science\Repository\VulgaRepository")
*/
class Vulga
{
    // sexe constants.
    const SEXE_FEMME      = 0;
    const SEXE_HOMME      = 1;
    const SEXE_GROUP      = 2;
    const SEXE_NON_BINARY = 3;
    const SEXE_NO_SEXE    = 4;
    const SEXE_NEUTRAL    = 5;


    // vulga state constants.
    const STATE_PUBLIC  = 0;
    const STATE_PRIVATE = 1;

    /**
    * @ORM\OneToMany(targetEntity="\Science\Entity\MainStats", mappedBy="vulga",orphanRemoval=true)
    * @ORM\JoinColumn(name="id", referencedColumnName="vulga")
    */
    protected $mainstats;

    /**
    * @ORM\OneToMany(targetEntity="\Science\Entity\Posts", mappedBy="vulga",orphanRemoval=true)
    * @ORM\JoinColumn(name="id", referencedColumnName="vulga")
    */
    protected $posts;

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
    * @ORM\Column(name="nom", type="string", length=512, nullable=false)
    */
    private $nom;

    /**
    * @var int
    *
    * @ORM\Column(name="sexe", type="integer", nullable=false)
    */
    private $sexe;

    /**
    * @var int
    *
    * @ORM\Column(name="private", type="integer", nullable=false)
    */
    private $private = '0';

    /**
    * @var \Langue
    *
    * @ORM\ManyToOne(targetEntity="\Science\Entity\Langue",inversedBy="vulga")
    * @ORM\JoinColumns({
    *   @ORM\JoinColumn(name="langue", referencedColumnName="id")
    * })
    */
    private $langue;

    /**
    * @var \Pays
    *
    * @ORM\ManyToOne(targetEntity="\Science\Entity\Pays",inversedBy="vulga")
    * @ORM\JoinColumns({
    *   @ORM\JoinColumn(name="pays", referencedColumnName="id")
    * })
    */
    private $pays;

    /**
    * @ORM\ManyToMany(targetEntity="\Science\Entity\Domaine", inversedBy="vulga")
    * @ORM\JoinTable(name="domaine_vulga",
    *      joinColumns={@ORM\JoinColumn(name="vulga", referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="domaine", referencedColumnName="id")}
    *      )
    */
    protected $domaine;

    /**
    * @ORM\ManyToMany(targetEntity="\Science\Entity\Plateforme", inversedBy="vulga")
    * @ORM\JoinTable(name="vulga_plateforme",
    *      joinColumns={@ORM\JoinColumn(name="vulga", referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="plateforme", referencedColumnName="id")}
    *      )
    */
    protected $plateforme;

    /**
    * Constructor.
    */
    public function __construct()
    {
        $this->plaateforme = new ArrayCollection();
        $this->domaine = new ArrayCollection();
        $this->mainstats = new ArrayCollection();
        $this->posts = new ArrayCollection();
    }

    /**
    * Returns domaine for this vulga.
    * @return array
    */
    public function getDomaine()
    {
        return $this->domaine;
    }

    /**
    * Adds a domaine to this vulga.
    * @param $domaine
    */
    public function addDomaine($domaine)
    {
        $this->domaine[] = $domaine;
        $domaine->addVulga($this);
    }

    public function removeDomaine($domaine)
    {
        if (!$this->domaine->contains($domaine)) {
            return;
        }
        $this->domaine->removeElement($domaine);
        $domaine->removeVulga($this);
    }

    /*
    * Returns associated langue.
    * @return \Science\Entity\Langue
    */
    public function getLangue()
    {
        return $this->langue;
    }

    /**
    * Sets associated langue.
    * @param \Science\Entity\Langue $langue
    */
    public function setLangue($langue)
    {
        $this->langue = $langue;
        $langue->addVulga($this);
    }

    /*
    * Returns associated pays.
    * @return \Science\Entity\Pays
    */
    public function getPays()
    {
        return $this->pays;
    }

    /**
    * Sets associated Pays.
    * @param \Science\Entity\Pays $pays
    */
    public function setPays($pays)
    {
        $this->pays = $pays;
        $pays->addVulga($this);
    }

    /**
    * Returns mainstats for this vulga.
    * @return array
    */
    public function getMainstats()
    {
        return $this->mainstats;
    }

    /**
    * Adds a mainstats to this vulga.
    * @param $mainstats
    */
    public function addMainstats($mainstats)
    {
        $this->mainstats[] = $mainstats;
    }

    /**
    * Returns plateforme for this vulga.
    * @return array
    */
    public function getPlateforme()
    {
        return $this->plateforme;
    }

    /**
    * Adds a plateforme to this vulga.
    * @param $domaine
    */
    public function addPlateforme($plateforme)
    {
        $this->plateforme[] = $plateforme;
        $plateforme->addVulga($this);
    }

    public function removePlateforme($plateforme)
    {
        if (!$this->plateforme->contains($plateforme)) {
            return;
        }
        $this->plateforme->removeElement($plateforme);
        $plateforme->removeVulga($this);
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
    * @return Vulga
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
    * Set sexe.
    *
    * @param string $sexe
    *
    * @return Vulga
    */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
    * Get sexe.
    *
    * @return string
    */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
    * Returns possible sexes as array.
    * @return array
    */
    public static function getSexeList()
    {
        return [
            self::SEXE_FEMME => 'Femme',
            self::SEXE_HOMME => 'Homme',
            self::SEXE_NON_BINARY => 'Non Binaire',
            self::SEXE_NO_SEXE => 'Asexué',
            self::SEXE_NEUTRAL => 'Neutre',
            self::SEXE_GROUP => 'Groupement',
        ];
    }

    /**
    * Returns sexe as string.
    * @return string
    */
    public function getSexeAsString($sexe = null)
    {
        if($sexe === null)
            $sexe = $this->sexe;
            
        $list = self::getSexeList();
        if(isset($list[$sexe]))
            return $list[$sexe];

        return 'Unknown';
    }

    /**
    * Returns possible statuses as array.
    * @return array
    */
    public static function getPrivateStatusList()
    {
        return [
            self::STATE_PUBLIC => 'Public',
            self::STATE_PRIVATE => 'Private'
        ];
    }

    /**
    * Returns user status as string.
    * @return string
    */
    public function getPrivateStatusAsString()
    {
        $list = self::getPrivateStatusList();
        if (isset($list[$this->private]))
            return $list[$this->private];

        return 'Unknown';
    }
    /**
    * Returns private status.
    * @return int
    */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
    * Sets private status
    * @param int $private
    */
    public function setPrivate($status)
    {
        $this->private = $status;
    }

    /**
    * Returns posts for this vulga.
    * @return array
    */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
    * Adds a post to this vulga.
    * @param $mainstats
    */
    public function addPosts($posts)
    {
        $this->posts[] = $posts;
    }
}
