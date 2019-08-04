<?php

namespace DoctrineORMModule\Proxy\__CG__\Science\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Vulga extends \Science\Entity\Vulga implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', 'mainstats', 'posts', '' . "\0" . 'Science\\Entity\\Vulga' . "\0" . 'id', '' . "\0" . 'Science\\Entity\\Vulga' . "\0" . 'nom', '' . "\0" . 'Science\\Entity\\Vulga' . "\0" . 'sexe', '' . "\0" . 'Science\\Entity\\Vulga' . "\0" . 'private', '' . "\0" . 'Science\\Entity\\Vulga' . "\0" . 'langue', '' . "\0" . 'Science\\Entity\\Vulga' . "\0" . 'pays', 'domaine', 'plateforme'];
        }

        return ['__isInitialized__', 'mainstats', 'posts', '' . "\0" . 'Science\\Entity\\Vulga' . "\0" . 'id', '' . "\0" . 'Science\\Entity\\Vulga' . "\0" . 'nom', '' . "\0" . 'Science\\Entity\\Vulga' . "\0" . 'sexe', '' . "\0" . 'Science\\Entity\\Vulga' . "\0" . 'private', '' . "\0" . 'Science\\Entity\\Vulga' . "\0" . 'langue', '' . "\0" . 'Science\\Entity\\Vulga' . "\0" . 'pays', 'domaine', 'plateforme'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Vulga $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getDomaine()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDomaine', []);

        return parent::getDomaine();
    }

    /**
     * {@inheritDoc}
     */
    public function addDomaine($domaine)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addDomaine', [$domaine]);

        return parent::addDomaine($domaine);
    }

    /**
     * {@inheritDoc}
     */
    public function removeDomaine($domaine)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeDomaine', [$domaine]);

        return parent::removeDomaine($domaine);
    }

    /**
     * {@inheritDoc}
     */
    public function getLangue()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLangue', []);

        return parent::getLangue();
    }

    /**
     * {@inheritDoc}
     */
    public function setLangue($langue)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLangue', [$langue]);

        return parent::setLangue($langue);
    }

    /**
     * {@inheritDoc}
     */
    public function getPays()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPays', []);

        return parent::getPays();
    }

    /**
     * {@inheritDoc}
     */
    public function setPays($pays)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPays', [$pays]);

        return parent::setPays($pays);
    }

    /**
     * {@inheritDoc}
     */
    public function getMainstats()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMainstats', []);

        return parent::getMainstats();
    }

    /**
     * {@inheritDoc}
     */
    public function addMainstats($mainstats)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addMainstats', [$mainstats]);

        return parent::addMainstats($mainstats);
    }

    /**
     * {@inheritDoc}
     */
    public function getPlateforme()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPlateforme', []);

        return parent::getPlateforme();
    }

    /**
     * {@inheritDoc}
     */
    public function addPlateforme($plateforme)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addPlateforme', [$plateforme]);

        return parent::addPlateforme($plateforme);
    }

    /**
     * {@inheritDoc}
     */
    public function removePlateforme($plateforme)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removePlateforme', [$plateforme]);

        return parent::removePlateforme($plateforme);
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setNom($nom)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNom', [$nom]);

        return parent::setNom($nom);
    }

    /**
     * {@inheritDoc}
     */
    public function getNom()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNom', []);

        return parent::getNom();
    }

    /**
     * {@inheritDoc}
     */
    public function setSexe($sexe)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSexe', [$sexe]);

        return parent::setSexe($sexe);
    }

    /**
     * {@inheritDoc}
     */
    public function getSexe()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSexe', []);

        return parent::getSexe();
    }

    /**
     * {@inheritDoc}
     */
    public function getSexeAsString($sexe = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSexeAsString', [$sexe]);

        return parent::getSexeAsString($sexe);
    }

    /**
     * {@inheritDoc}
     */
    public function getPrivateStatusAsString()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrivateStatusAsString', []);

        return parent::getPrivateStatusAsString();
    }

    /**
     * {@inheritDoc}
     */
    public function getPrivate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrivate', []);

        return parent::getPrivate();
    }

    /**
     * {@inheritDoc}
     */
    public function setPrivate($status)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPrivate', [$status]);

        return parent::setPrivate($status);
    }

    /**
     * {@inheritDoc}
     */
    public function getPosts()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPosts', []);

        return parent::getPosts();
    }

    /**
     * {@inheritDoc}
     */
    public function addPosts($posts)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addPosts', [$posts]);

        return parent::addPosts($posts);
    }

}
