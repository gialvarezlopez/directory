<?php

namespace AppBundle\Entity;

/**
 * City
 */
class City
{
    /**
     * @var integer
     */
    private $citId;

    /**
     * @var string
     */
    private $citName;

    /**
     * @var boolean
     */
    private $citActive = true;

    /**
     * @var \AppBundle\Entity\State
     */
    private $sta;


    /**
     * Get citId
     *
     * @return integer
     */
    public function getCitId()
    {
        return $this->citId;
    }

    /**
     * Set citName
     *
     * @param string $citName
     *
     * @return City
     */
    public function setCitName($citName)
    {
        $this->citName = $citName;

        return $this;
    }

    /**
     * Get citName
     *
     * @return string
     */
    public function getCitName()
    {
        return $this->citName;
    }

    /**
     * Set citActive
     *
     * @param boolean $citActive
     *
     * @return City
     */
    public function setCitActive($citActive)
    {
        $this->citActive = $citActive;

        return $this;
    }

    /**
     * Get citActive
     *
     * @return boolean
     */
    public function getCitActive()
    {
        return $this->citActive;
    }

    /**
     * Set sta
     *
     * @param \AppBundle\Entity\State $sta
     *
     * @return City
     */
    public function setSta(\AppBundle\Entity\State $sta = null)
    {
        $this->sta = $sta;

        return $this;
    }

    /**
     * Get sta
     *
     * @return \AppBundle\Entity\State
     */
    public function getSta()
    {
        return $this->sta;
    }
}
