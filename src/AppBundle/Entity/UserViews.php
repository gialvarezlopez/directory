<?php

namespace AppBundle\Entity;

/**
 * UserViews
 */
class UserViews
{

    /**
     * @var integer
     */
    private $visId;

    /**
     * @var string
     */
    private $visReferencia;

    /**
     * @var \DateTime
     */
    private $visFechaCrea = 'CURRENT_TIMESTAMP';

    /**
     * Get visId
     *
     * @return integer
     */
    public function getVisId()
    {
        return $this->visId;
    }

    /**
     * Set visReferencia
     *
     * @param string $visReferencia
     *
     * @return UserViews
     */
    public function setVisReferencia($visReferencia)
    {
        $this->visReferencia = $visReferencia;

        return $this;
    }

    /**
     * Get visReferencia
     *
     * @return string
     */
    public function getVisReferencia()
    {
        return $this->visReferencia;
    }

    /**
     * Set visFechaCrea
     *
     * @param \DateTime $visFechaCrea
     *
     * @return UserViews
     */
    public function setVisFechaCrea($visFechaCrea)
    {
        $this->visFechaCrea = $visFechaCrea;

        return $this;
    }

    /**
     * Get visFechaCrea
     *
     * @return \DateTime
     */
    public function getVisFechaCrea()
    {
        return $this->visFechaCrea;
    }

    /**
     * @var \AppBundle\Entity\User
     */
    private $visUsu;


    /**
     * Set visUsu
     *
     * @param \AppBundle\Entity\User $visUsu
     *
     * @return UserViews
     */
    public function setVisUsu(\AppBundle\Entity\User $visUsu = null)
    {
        $this->visUsu = $visUsu;

        return $this;
    }

    /**
     * Get visUsu
     *
     * @return \AppBundle\Entity\User
     */
    public function getVisUsu()
    {
        return $this->visUsu;
    }
}
