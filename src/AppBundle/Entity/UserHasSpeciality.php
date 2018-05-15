<?php

namespace AppBundle\Entity;

/**
 * UserHasSpeciality
 */
class UserHasSpeciality
{
    /**
     * @var integer
     */
    private $uhsId;

    /**
     * @var \AppBundle\Entity\Speciality
     */
    private $sp;

    /**
     * @var \AppBundle\Entity\User
     */
    private $usr;


    /**
     * Get uhsId
     *
     * @return integer
     */
    public function getUhsId()
    {
        return $this->uhsId;
    }

    /**
     * Set sp
     *
     * @param \AppBundle\Entity\Speciality $sp
     *
     * @return UserHasSpeciality
     */
    public function setSp(\AppBundle\Entity\Speciality $sp = null)
    {
        $this->sp = $sp;

        return $this;
    }

    /**
     * Get sp
     *
     * @return \AppBundle\Entity\Speciality
     */
    public function getSp()
    {
        return $this->sp;
    }

    /**
     * Set usr
     *
     * @param \AppBundle\Entity\User $usr
     *
     * @return UserHasSpeciality
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

