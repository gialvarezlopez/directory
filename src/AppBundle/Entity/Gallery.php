<?php

namespace AppBundle\Entity;

/**
 * Gallery
 */
class Gallery
{
    /**
     * @var integer
     */
    private $gaId;

    /**
     * @var string
     */
    private $gaName;

    /**
     * @var string
     */
    private $gaDescription;

    /**
     * @var boolean
     */
    private $gaActive = true;

    /**
     * @var integer
     */
    private $gaOrder;

    /**
     * @var \DateTime
     */
    private $gaCreated = 'CURRENT_TIMESTAMP';

    /**
     * @var \AppBundle\Entity\User
     */
    private $usr;


    public function __construct()
    {
        $this->gaCreated = new \DateTime();
    }

    /**
     * Get gaId
     *
     * @return integer
     */
    public function getGaId()
    {
        return $this->gaId;
    }

    /**
     * Set gaName
     *
     * @param string $gaName
     *
     * @return Gallery
     */
    public function setGaName($gaName)
    {
        $this->gaName = $gaName;

        return $this;
    }

    /**
     * Get gaName
     *
     * @return string
     */
    public function getGaName()
    {
        return $this->gaName;
    }

    /**
     * Set gaDescription
     *
     * @param string $gaDescription
     *
     * @return Gallery
     */
    public function setGaDescription($gaDescription)
    {
        $this->gaDescription = $gaDescription;

        return $this;
    }

    /**
     * Get gaDescription
     *
     * @return string
     */
    public function getGaDescription()
    {
        return $this->gaDescription;
    }

    /**
     * Set gaActive
     *
     * @param boolean $gaActive
     *
     * @return Gallery
     */
    public function setGaActive($gaActive)
    {
        $this->gaActive = $gaActive;

        return $this;
    }

    /**
     * Get gaActive
     *
     * @return boolean
     */
    public function getGaActive()
    {
        return $this->gaActive;
    }

    /**
     * Set gaOrder
     *
     * @param integer $gaOrder
     *
     * @return Gallery
     */
    public function setGaOrder($gaOrder)
    {
        $this->gaOrder = $gaOrder;

        return $this;
    }

    /**
     * Get gaOrder
     *
     * @return integer
     */
    public function getGaOrder()
    {
        return $this->gaOrder;
    }

    /**
     * Set gaCreated
     *
     * @param \DateTime $gaCreated
     *
     * @return Gallery
     */
    public function setGaCreated($gaCreated)
    {
        $this->gaCreated = $gaCreated;

        return $this;
    }

    /**
     * Get gaCreated
     *
     * @return \DateTime
     */
    public function getGaCreated()
    {
        return $this->gaCreated;
    }

    /**
     * Set usr
     *
     * @param \AppBundle\Entity\User $usr
     *
     * @return Gallery
     */
    public function setUsr(\AppBundle\Entity\User $usr = null)
    {
        $this->usr = $usr;

        return $this;
    }

    /**
     * Get usr
     *
     * @return \AppBundle\Entity\User
     */
    public function getUsr()
    {
        return $this->usr;
    }
}
