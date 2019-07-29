<?php

namespace DoctrineORMModule\Proxy\__CG__\Science\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Plateforme extends \Science\Entity\Plateforme implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', 'posts', 'mainstats', '' . "\0" . 'Science\\Entity\\Plateforme' . "\0" . 'id', '' . "\0" . 'Science\\Entity\\Plateforme' . "\0" . 'nom', '' . "\0" . 'Science\\Entity\\Plateforme' . "\0" . 'address', '' . "\0" . 'Science\\Entity\\Plateforme' . "\0" . 'postName', '' . "\0" . 'Science\\Entity\\Plateforme' . "\0" . 'idExtractPattern', 'vulga'];
        }

        return ['__isInitialized__', 'posts', 'mainstats', '' . "\0" . 'Science\\Entity\\Plateforme' . "\0" . 'id', '' . "\0" . 'Science\\Entity\\Plateforme' . "\0" . 'nom', '' . "\0" . 'Science\\Entity\\Plateforme' . "\0" . 'address', '' . "\0" . 'Science\\Entity\\Plateforme' . "\0" . 'postName', '' . "\0" . 'Science\\Entity\\Plateforme' . "\0" . 'idExtractPattern', 'vulga'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Plateforme $proxy) {
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
    public function getVulga()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVulga', []);

        return parent::getVulga();
    }

    /**
     * {@inheritDoc}
     */
    public function addVulga($vulga)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addVulga', [$vulga]);

        return parent::addVulga($vulga);
    }

    /**
     * {@inheritDoc}
     */
    public function removeVulga($vulga)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeVulga', [$vulga]);

        return parent::removeVulga($vulga);
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
    public function setAddress($address)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAddress', [$address]);

        return parent::setAddress($address);
    }

    /**
     * {@inheritDoc}
     */
    public function getAddress()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAddress', []);

        return parent::getAddress();
    }

    /**
     * {@inheritDoc}
     */
    public function setPostName($postName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPostName', [$postName]);

        return parent::setPostName($postName);
    }

    /**
     * {@inheritDoc}
     */
    public function getPostName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPostName', []);

        return parent::getPostName();
    }

    /**
     * {@inheritDoc}
     */
    public function setIdExtractPattern($idExtractPattern)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIdExtractPattern', [$idExtractPattern]);

        return parent::setIdExtractPattern($idExtractPattern);
    }

    /**
     * {@inheritDoc}
     */
    public function getIdExtractPattern()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIdExtractPattern', []);

        return parent::getIdExtractPattern();
    }

}
