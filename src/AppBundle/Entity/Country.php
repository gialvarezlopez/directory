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
     * @var string
     */
    private $staLat;

    /**
     * @var string
     */
    private $staLng;

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
     * Set staLat
     *
     * @param string $staLat
     *
     * @return Country
     */
    public function setStaLat($staLat)
    {
        $this->staLat = $staLat;

        return $this;
    }

    /**
     * Get staLat
     *
     * @return string
     */
    public function getStaLat()
    {
        return $this->staLat;
    }

    /**
     * Set staLng
     *
     * @param string $staLng
     *
     * @return Country
     */
    public function setStaLng($staLng)
    {
        $this->staLng = $staLng;

        return $this;
    }

    /**
     * Get staLng
     *
     * @return string
     */
    public function getStaLng()
    {
        return $this->staLng;
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
    /**
     * @var string
     */
    private $isoCode;


    /**
     * Set isCode
     *
     * @param string $isoCode
     *
     * @return Country
     */
    public function setIsoCode($isoCode)
    {
        $this->isoCode = $isoCode;

        return $this;
    }

    /**
     * Get isoCode
     *
     * @return string
     */
    public function getIsoCode()
    {
        return $this->isoCode;
    }
}
