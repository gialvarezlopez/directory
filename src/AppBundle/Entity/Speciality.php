<?php

namespace AppBundle\Entity;

/**
 * Speciality
 */
class Speciality
{
    /**
     * @var integer
     */
    private $spId;

    /**
     * @var string
     */
    private $spName;

    /**
     * @var \DateTime
     */
    private $spCreated = 'CURRENT_TIMESTAMP';

    /**
     * @var boolean
     */
    private $spActive = true;

    /**
     * @var \AppBundle\Entity\User
     */
    private $usr;


    /**
     * Get spId
     *
     * @return integer
     */
    public function getSpId()
    {
        return $this->spId;
    }

    /**
     * Set spName
     *
     * @param string $spName
     *
     * @return Speciality
     */
    public function setSpName($spName)
    {
        $this->spName = $spName;

        return $this;
    }

    /**
     * Get spName
     *
     * @return string
     */
    public function getSpName()
    {
        return $this->spName;
    }

    /**
     * Set spCreated
     *
     * @param \DateTime $spCreated
     *
     * @return Speciality
     */
    public function setSpCreated($spCreated)
    {
        $this->spCreated = $spCreated;

        return $this;
    }

    /**
     * Get spCreated
     *
     * @return \DateTime
     */
    public function getSpCreated()
    {
        return $this->spCreated;
    }

    /**
     * Set spActive
     *
     * @param boolean $spActive
     *
     * @return Speciality
     */
    public function setSpActive($spActive)
    {
        $this->spActive = $spActive;

        return $this;
    }

    /**
     * Get spActive
     *
     * @return boolean
     */
    public function getSpActive()
    {
        return $this->spActive;
    }

    /**
     * Set usr
     *
     * @param \AppBundle\Entity\User $usr
     *
     * @return Speciality
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
