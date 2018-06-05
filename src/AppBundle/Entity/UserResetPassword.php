<?php

namespace AppBundle\Entity;

/**
 * UserResetPassword
 */
class UserResetPassword
{
    /**
     * @var integer
     */
    private $uspId;

    /**
     * @var string
     */
    private $uspToken;

    /**
     * @var string
     */
    private $uspNewPassword;

    /**
     * @var \DateTime
     */
    private $uspCreated;

    /**
     * @var boolean
     */
    private $uspActive = '1';

    /**
     * @var \AppBundle\Entity\User
     */
    private $usr;


    /**
     * Get uspId
     *
     * @return integer
     */
    public function getUspId()
    {
        return $this->uspId;
    }

    /**
     * Set uspToken
     *
     * @param string $uspToken
     *
     * @return UserResetPassword
     */
    public function setUspToken($uspToken)
    {
        $this->uspToken = $uspToken;

        return $this;
    }

    /**
     * Get uspToken
     *
     * @return string
     */
    public function getUspToken()
    {
        return $this->uspToken;
    }

    /**
     * Set uspNewPassword
     *
     * @param string $uspNewPassword
     *
     * @return UserResetPassword
     */
    public function setUspNewPassword($uspNewPassword)
    {
        $this->uspNewPassword = $uspNewPassword;

        return $this;
    }

    /**
     * Get uspNewPassword
     *
     * @return string
     */
    public function getUspNewPassword()
    {
        return $this->uspNewPassword;
    }

    /**
     * Set uspCreated
     *
     * @param \DateTime $uspCreated
     *
     * @return UserResetPassword
     */
    public function setUspCreated($uspCreated)
    {
        $this->uspCreated = $uspCreated;

        return $this;
    }

    /**
     * Get uspCreated
     *
     * @return \DateTime
     */
    public function getUspCreated()
    {
        return $this->uspCreated;
    }

    /**
     * Set uspActive
     *
     * @param boolean $uspActive
     *
     * @return UserResetPassword
     */
    public function setUspActive($uspActive)
    {
        $this->uspActive = $uspActive;

        return $this;
    }

    /**
     * Get uspActive
     *
     * @return boolean
     */
    public function getUspActive()
    {
        return $this->uspActive;
    }

    /**
     * Set usr
     *
     * @param \AppBundle\Entity\User $usr
     *
     * @return UserResetPassword
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
