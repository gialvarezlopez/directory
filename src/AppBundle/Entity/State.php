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
