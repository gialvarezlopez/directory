<?php

namespace AppBundle\Entity;

/**
 * SocialNetwork
 */
class SocialNetwork
{
    /**
     * @var integer
     */
    private $snId;

    /**
     * @var string
     */
    private $snType;

    /**
     * @var string
     */
    private $snKey;

    /**
     * @var boolean
     */
    private $snActive = true;

    /**
     * @var \DateTime
     */
    private $snCreated;


    /**
     * Get snId
     *
     * @return integer
     */
    public function getSnId()
    {
        return $this->snId;
    }

    /**
     * Set snType
     *
     * @param string $snType
     *
     * @return SocialNetwork
     */
    public function setSnType($snType)
    {
        $this->snType = $snType;

        return $this;
    }

    /**
     * Get snType
     *
     * @return string
     */
    public function getSnType()
    {
        return $this->snType;
    }

    /**
     * Set snKey
     *
     * @param string $snKey
     *
     * @return SocialNetwork
     */
    public function setSnKey($snKey)
    {
        $this->snKey = $snKey;

        return $this;
    }

    /**
     * Get snKey
     *
     * @return string
     */
    public function getSnKey()
    {
        return $this->snKey;
    }

    /**
     * Set snActive
     *
     * @param boolean $snActive
     *
     * @return SocialNetwork
     */
    public function setSnActive($snActive)
    {
        $this->snActive = $snActive;

        return $this;
    }

    /**
     * Get snActive
     *
     * @return boolean
     */
    public function getSnActive()
    {
        return $this->snActive;
    }

    /**
     * Set snCreated
     *
     * @param \DateTime $snCreated
     *
     * @return SocialNetwork
     */
    public function setSnCreated($snCreated)
    {
        $this->snCreated = $snCreated;

        return $this;
    }

    /**
     * Get snCreated
     *
     * @return \DateTime
     */
    public function getSnCreated()
    {
        return $this->snCreated;
    }
    /**
     * @var string
     */
    private $snIcon;


    /**
     * Set snIcon
     *
     * @param string $snIcon
     *
     * @return SocialNetwork
     */
    public function setSnIcon($snIcon)
    {
        $this->snIcon = $snIcon;

        return $this;
    }

    /**
     * Get snIcon
     *
     * @return string
     */
    public function getSnIcon()
    {
        return $this->snIcon;
    }
    /**
     * @var string
     */
    private $snBackground;


    /**
     * Set snBackground
     *
     * @param string $snBackground
     *
     * @return SocialNetwork
     */
    public function setSnBackground($snBackground)
    {
        $this->snBackground = $snBackground;

        return $this;
    }

    /**
     * Get snBackground
     *
     * @return string
     */
    public function getSnBackground()
    {
        return $this->snBackground;
    }
}
