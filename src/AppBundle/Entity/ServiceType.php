<?php

namespace AppBundle\Entity;

/**
 * ServiceType
 */
class ServiceType
{
    /**
     * @var integer
     */
    private $stId;

    /**
     * @var string
     */
    private $stName;

    /**
     * @var boolean
     */
    private $stActive = true;


    /**
     * Get stId
     *
     * @return integer
     */
    public function getStId()
    {
        return $this->stId;
    }

    /**
     * Set stName
     *
     * @param string $stName
     *
     * @return ServiceType
     */
    public function setStName($stName)
    {
        $this->stName = $stName;

        return $this;
    }

    /**
     * Get stName
     *
     * @return string
     */
    public function getStName()
    {
        return $this->stName;
    }

    /**
     * Set stActive
     *
     * @param boolean $stActive
     *
     * @return ServiceType
     */
    public function setStActive($stActive)
    {
        $this->stActive = $stActive;

        return $this;
    }

    /**
     * Get stActive
     *
     * @return boolean
     */
    public function getStActive()
    {
        return $this->stActive;
    }
}
