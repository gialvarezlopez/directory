<?php

namespace AppBundle\Entity;

/**
 * UserHasSocialNetwork
 */
class UserHasSocialNetwork
{
    /**
     * @var integer
     */
    private $usnId;

    /**
     * @var string
     */
    private $usnLink;

    /**
     * @var boolean
     */
    private $usnActive = '1';

    /**
     * @var \AppBundle\Entity\SocialNetwork
     */
    private $sn;

    /**
     * @var \AppBundle\Entity\User
     */
    private $usr;


    /**
     * Get usnId
     *
     * @return integer
     */
    public function getUsnId()
    {
        return $this->usnId;
    }

    /**
     * Set usnLink
     *
     * @param string $usnLink
     *
     * @return UserHasSocialNetwork
     */
    public function setUsnLink($usnLink)
    {
        $this->usnLink = $usnLink;

        return $this;
    }

    /**
     * Get usnLink
     *
     * @return string
     */
    public function getUsnLink()
    {
        return $this->usnLink;
    }

    /**
     * Set usnActive
     *
     * @param boolean $usnActive
     *
     * @return UserHasSocialNetwork
     */
    public function setUsnActive($usnActive)
    {
        $this->usnActive = $usnActive;

        return $this;
    }

    /**
     * Get usnActive
     *
     * @return boolean
     */
    public function getUsnActive()
    {
        return $this->usnActive;
    }

    /**
     * Set sn
     *
     * @param \AppBundle\Entity\SocialNetwork $sn
     *
     * @return UserHasSocialNetwork
     */
    public function setSn(\AppBundle\Entity\SocialNetwork $sn = null)
    {
        $this->sn = $sn;

        return $this;
    }

    /**
     * Get sn
     *
     * @return \AppBundle\Entity\SocialNetwork
     */
    public function getSn()
    {
        return $this->sn;
    }

    /**
     * Set usr
     *
     * @param \AppBundle\Entity\User $usr
     *
     * @return UserHasSocialNetwork
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
