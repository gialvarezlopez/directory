<?php

namespace AppBundle\Entity;

/**
 * State
 */
class State
{
    /**
     * @var integer
     */
    private $staId;

    /**
     * @var string
     */
    private $staName;

    /**
     * @var string
     */
    private $staLat;

    /**
     * @var string
     */
    private $staLng;

    /**
     * @var string
     */
    private $staCode;

    /**
     * @var boolean
     */
    private $staActive = true;

    /**
     * @var \AppBundle\Entity\Country
     */
    private $cou;


    /**
     * Get staId
     *
     * @return integer
     */
    public function getStaId()
    {
        return $this->staId;
    }

    /**
     * Set staName
     *
     * @param string $staName
     *
     * @return State
     */
    public function setStaName($staName)
    {
        $this->staName = $staName;

        return $this;
    }

    /**
     * Get staName
     *
     * @return string
     */
    public function getStaName()
    {
        return $this->staName;
    }
  

    /**
     * Set staLat
     *
     * @param string $staLat
     *
     * @return State
     */
    public function setStalat($staLat)
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
     * @return State
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
     * Set staCode
     *
     * @param string $staCode
     *
     * @return Code
     */
    public function setStaCode($staCode)
    {
        $this->staCode = $staCode;

        return $this;
    }

    /**
     * Get staCode
     *
     * @return string
     */
    public function getStaCode()
    {
        return $this->staCode;
    }

    /**
     * Set staActive
     *
     * @param boolean $staActive
     *
     * @return State
     */
    public function setStaActive($staActive)
    {
        $this->staActive = $staActive;

        return $this;
    }

    /**
     * Get staActive
     *
     * @return boolean
     */
    public function getStaActive()
    {
        return $this->staActive;
    }

    /**
     * Set cou
     *
     * @param \AppBundle\Entity\Country $cou
     *
     * @return State
     */
    public function setCou(\AppBundle\Entity\Country $cou = null)
    {
        $this->cou = $cou;

        return $this;
    }

    /**
     * Get cou
     *
     * @return \AppBundle\Entity\Country
     */
    public function getCou()
    {
        return $this->cou;
    }
}
