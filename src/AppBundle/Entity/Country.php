<?php

namespace AppBundle\Entity;

/**
 * Country
 */
class Country
{
    /**
     * @var integer
     */
    private $couId;

    /**
     * @var string
     */
    private $couName;

    /**
     * @var boolean
     */
    private $couActive = true;


    /**
     * Get couId
     *
     * @return integer
     */
    public function getCouId()
    {
        return $this->couId;
    }

    /**
     * Set couName
     *
     * @param string $couName
     *
     * @return Country
     */
    public function setCouName($couName)
    {
        $this->couName = $couName;

        return $this;
    }

    /**
     * Get couName
     *
     * @return string
     */
    public function getCouName()
    {
        return $this->couName;
    }

    /**
     * Set couActive
     *
     * @param boolean $couActive
     *
     * @return Country
     */
    public function setCouActive($couActive)
    {
        $this->couActive = $couActive;

        return $this;
    }

    /**
     * Get couActive
     *
     * @return boolean
     */
    public function getCouActive()
    {
        return $this->couActive;
    }

    public function __toString()
    {
        return $this->couName;
    }
}
