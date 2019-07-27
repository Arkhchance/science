<?php
namespace Science\Entity;

use Doctrine\ORM\Mapping as ORM;
use Science\Entity\Plateforme;
use Science\Entity\Vulga;

/**
* Posts
*
* @ORM\Table(name="posts", indexes={@ORM\Index(name="plateforme_post", columns={"plateforme"})})
* @ORM\Entity
*/
class Posts
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
    * @var int
    *
    * @ORM\Column(name="vue", type="integer", nullable=false)
    */
    private $vue;

    /**
    * @var string
    *
    * @ORM\Column(name="Titre", type="string", length=255, nullable=false)
    */
    private $titre;

    /**
    * @var string|null
    *
    * @ORM\Column(name="Description", type="text", length=65535, nullable=true)
    */
    private $description;

    /**
    * @var int
    *
    * @ORM\Column(name="nb_like", type="integer", nullable=false)
    */
    private $nbLike;

    /**
    * @var int
    *
    * @ORM\Column(name="nb_dislike", type="integer", nullable=false)
    */
    private $nbDislike;

    /**
    * @var int
    *
    * @ORM\Column(name="comments", type="integer", nullable=false)
    */
    private $comments;

    /**
    * @var \Plateforme
    *
    * @ORM\ManyToOne(targetEntity="\Science\Entity\Plateforme",inversedBy="posts")
    * @ORM\JoinColumns({
    *   @ORM\JoinColumn(name="plateforme", referencedColumnName="id")
    * })
    */
    private $plateforme;

    /**
    * @var \Vulga
    *
    * @ORM\ManyToOne(targetEntity="\Science\Entity\Vulga",inversedBy="posts")
    * @ORM\JoinColumns({
    *   @ORM\JoinColumn(name="vulga", referencedColumnName="id")
    * })
    */
    private $vulga;

    /*
    * Returns associated vulga.
    * @return \Science\Entity\Vulga
    */
    public function getVulga()
    {
        return $this->vulga;
    }

    /**
    * Sets associated vulga.
    * @param \Science\Entity\Vulga $vulga
    */
    public function setVulga($vulga)
    {
        $this->vulga = $vulga;
        $vulga->addPosts($this);
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
    * Set vue.
    *
    * @param string $vue
    *
    * @return Posts
    */
    public function setVue($vue)
    {
        $this->vue = $vue;

        return $this;
    }

    /**
    * Get vue.
    *
    * @return string
    */
    public function getVue()
    {
        return $this->vue;
    }

    /**
    * Set titre.
    *
    * @param string $titre
    *
    * @return Posts
    */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
    * Get titre.
    *
    * @return string
    */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
    * Set description.
    *
    * @param string $description
    *
    * @return Posts
    */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
    * Get description.
    *
    * @return string
    */
    public function getDescription()
    {
        return $this->description;
    }

    /**
    * Set nbLike.
    *
    * @param int $nbLike
    *
    * @return Posts
    */
    public function setNbLike($nbLike)
    {
        $this->nbLike = $nbLike;

        return $this;
    }

    /**
    * Get nbLike.
    *
    * @return int
    */
    public function getNbLike()
    {
        return $this->nbLike;
    }

    /**
    * Set nbDislike.
    *
    * @param int $nbDislike
    *
    * @return Posts
    */
    public function setNbDislike($nbDislike)
    {
        $this->nbDislike = $nbDislike;

        return $this;
    }

    /**
    * Get nbDislike.
    *
    * @return int
    */
    public function getNbDislike()
    {
        return $this->nbDislike;
    }

    /**
    * Set comments.
    *
    * @param int $comments
    *
    * @return Posts
    */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
    * Get comments.
    *
    * @return int
    */
    public function getComments()
    {
        return $this->comments;
    }
    /*
    * Returns associated plateforme.
    * @return \Science\Entity\Plateforme
    */
    public function getPlateforme()
    {
        return $this->plateforme;
    }

    /**
    * Sets associated langue.
    * @param \Science\Entity\Plateforme $plateforme
    */
    public function setPlateforme($plateforme)
    {
        $this->plateforme = $plateforme;
        $plateforme->addPosts($this);
    }
}
