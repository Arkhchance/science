<?php
namespace Science\Entity;

use Doctrine\ORM\Mapping as ORM;
use Science\Entity\Vulga;
use Science\Entity\Plateforme;

/**
* MainStats
*
* @ORM\Table(name="main_stats", indexes={@ORM\Index(name="vulga_link", columns={"vulga"}), @ORM\Index(name="plateforme_link", columns={"plateforme"})})
* @ORM\Entity
*/
class MainStats
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
    * @ORM\Column(name="follower", type="integer", nullable=false)
    */
    private $follower;

    /**
    * @var \DateTime
    *
    * @ORM\Column(name="date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
    */
    private $date = 'CURRENT_TIMESTAMP';

    /**
    * @var string
    *
    * @ORM\Column(name="link", type="string", length=255, nullable=false)
    */
    private $link;

    /**
    * @var string
    *
    * @ORM\Column(name="plateforme_id", type="string", length=255, nullable=false)
    */
    private $plateformeId;

    /**
    * @var int
    *
    * @ORM\Column(name="posts", type="integer", nullable=false)
    */
    private $posts;

    /**
    * @var int
    *
    * @ORM\Column(name="total_like", type="integer", nullable=false)
    */
    private $totalLike;

    /**
    * @var int
    *
    * @ORM\Column(name="total_dislike", type="integer", nullable=false)
    */
    private $totalDislike;

    /**
    * @var \Plateforme
    *
    * @ORM\ManyToOne(targetEntity="\Science\Entity\Plateforme",inversedBy="mainstats")
    * @ORM\JoinColumns({
    *   @ORM\JoinColumn(name="plateforme", referencedColumnName="id")
    * })
    */
    private $plateforme;

    /**
    * @var \Vulga
    *
    * @ORM\ManyToOne(targetEntity="\Science\Entity\Vulga",inversedBy="mainstats")
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
        $vulga->addMainstats($this);
    }

    /*
    * Returns associated plateforme.
    * @return \Science\Entity\Vulga
    */
    public function getPlateforme()
    {
        return $this->plateforme;
    }

    /**
    * Sets associated plateforme.
    * @param \Science\Entity\Plateforme $plateforme
    */
    public function setPlateforme($plateforme)
    {
        $this->plateforme = $plateforme;
        $plateforme->addMainstats($this);
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
    * Set follower.
    *
    * @param string $follower
    *
    * @return MainStats
    */
    public function setFollower($follower)
    {
        $this->follower = $follower;

        return $this;
    }

    /**
    * Get follower.
    *
    * @return string
    */
    public function getFollower()
    {
        return $this->follower;
    }

    /**
    * Set date.
    *
    * @param string $date
    *
    * @return MainStats
    */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
    * Get date.
    *
    * @return string
    */
    public function getDate()
    {
        return $this->date;
    }

    /**
    * Set link.
    *
    * @param string $link
    *
    * @return MainStats
    */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
    * Get link.
    *
    * @return string
    */
    public function getLink()
    {
        return $this->link;
    }

    /**
    * Set plateformeId.
    *
    * @param string $plateformeId
    *
    * @return MainStats
    */
    public function setPlateformeId($plateformeId)
    {
        $this->plateformeId = $plateformeId;

        return $this;
    }

    /**
    * Get plateformeId.
    *
    * @return string
    */
    public function getPlateformeId()
    {
        return $this->plateformeId;
    }

    /**
    * Set posts.
    *
    * @param string $posts
    *
    * @return MainStats
    */
    public function setPosts($posts)
    {
        $this->posts = $posts;

        return $this;
    }

    /**
    * Get posts.
    *
    * @return string
    */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
    * Set totalLike.
    *
    * @param string $totalLike
    *
    * @return MainStats
    */
    public function setTotalLike($totalLike)
    {
        $this->totalLike = $totalLike;

        return $this;
    }

    /**
    * Get totalLike.
    *
    * @return string
    */
    public function getTotalLike()
    {
        return $this->totalLike;
    }

    /**
    * Set totalDislike.
    *
    * @param string $totalDislike
    *
    * @return MainStats
    */
    public function setTotalDislike($totalDislike)
    {
        $this->totalDislike = $totalDislike;

        return $this;
    }

    /**
    * Get totalDislike.
    *
    * @return string
    */
    public function getTotalDislike()
    {
        return $this->totalDislike;
    }
}
