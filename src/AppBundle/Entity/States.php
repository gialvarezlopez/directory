<?php

namespace AppBundle\Entity;

/**
 * States
 */
class States
{
    /**
     * @var string
     */
    private $stateCode;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $lat;

    /**
     * @var string
     */
    private $lng;


    /**
     * Get stateCode
     *
     * @return string
     */
    public function getStateCode()
    {
        return $this->stateCode;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return States
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set lat
     *
     * @param string $lat
     *
     * @return States
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param string $lng
     *
     * @return States
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return string
     */
    public function getLng()
    {
        return $this->lng;
    }
}

