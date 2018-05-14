<?php

namespace AppBundle\Entity;

/**
 * ContactInfo
 */
class ContactInfo
{
    /**
     * @var integer
     */
    private $ciId;

    /**
     * @var string
     */
    private $ciPhone1;

    /**
     * @var string
     */
    private $ciPhone2;

    /**
     * @var string
     */
    private $ciAddress;

    /**
     * @var string
     */
    private $ciLat;

    /**
     * @var string
     */
    private $ciLng;

    /**
     * @var boolean
     */
    private $ciActive = true;

    /**
     * @var string
     */
    private $ciSchedule;

    /**
     * @var \DateTime
     */
    private $ciCreated = 'CURRENT_TIMESTAMP';

    /**
     * @var \AppBundle\Entity\City
     */
    private $cit;

    /**
     * @var \AppBundle\Entity\User
     */
    private $usr;


    /**
     * Get ciId
     *
     * @return integer
     */
    public function getCiId()
    {
        return $this->ciId;
    }

    public function __construct()
    {
        $this->ciCreated = new \DateTime();
    }

    /**
     * Set ciPhone1
     *
     * @param string $ciPhone1
     *
     * @return ContactInfo
     */
    public function setCiPhone1($ciPhone1)
    {
        $this->ciPhone1 = $ciPhone1;

        return $this;
    }

    /**
     * Get ciPhone1
     *
     * @return string
     */
    public function getCiPhone1()
    {
        return $this->ciPhone1;
    }

    /**
     * Set ciPhone2
     *
     * @param string $ciPhone2
     *
     * @return ContactInfo
     */
    public function setCiPhone2($ciPhone2)
    {
        $this->ciPhone2 = $ciPhone2;

        return $this;
    }

    /**
     * Get ciPhone2
     *
     * @return string
     */
    public function getCiPhone2()
    {
        return $this->ciPhone2;
    }

    /**
     * Set ciAddress
     *
     * @param string $ciAddress
     *
     * @return ContactInfo
     */
    public function setCiAddress($ciAddress)
    {
        $this->ciAddress = $ciAddress;

        return $this;
    }

    /**
     * Get ciAddress
     *
     * @return string
     */
    public function getCiAddress()
    {
        return $this->ciAddress;
    }

    /**
     * Set ciLat
     *
     * @param string $ciLat
     *
     * @return ContactInfo
     */
    public function setCiLat($ciLat)
    {
        $this->ciLat = $ciLat;

        return $this;
    }

    /**
     * Get ciLat
     *
     * @return string
     */
    public function getCiLat()
    {
        return $this->ciLat;
    }

    /**
     * Set ciLng
     *
     * @param string $ciLng
     *
     * @return ContactInfo
     */
    public function setCiLng($ciLng)
    {
        $this->ciLng = $ciLng;

        return $this;
    }

    /**
     * Get ciLng
     *
     * @return string
     */
    public function getCiLng()
    {
        return $this->ciLng;
    }

    /**
     * Set ciActive
     *
     * @param boolean $ciActive
     *
     * @return ContactInfo
     */
    public function setCiActive($ciActive)
    {
        $this->ciActive = $ciActive;

        return $this;
    }

    /**
     * Get ciActive
     *
     * @return boolean
     */
    public function getCiActive()
    {
        return $this->ciActive;
    }

    /**
     * Set ciSchedule
     *
     * @param string $ciSchedule
     *
     * @return ContactInfo
     */
    public function setCiSchedule($ciSchedule)
    {
        $this->ciSchedule = $ciSchedule;

        return $this;
    }

    /**
     * Get ciSchedule
     *
     * @return string
     */
    public function getCiSchedule()
    {
        return $this->ciSchedule;
    }

    /**
     * Set ciCreated
     *
     * @param \DateTime $ciCreated
     *
     * @return ContactInfo
     */
    public function setCiCreated($ciCreated)
    {
        $this->ciCreated = $ciCreated;

        return $this;
    }

    /**
     * Get ciCreated
     *
     * @return \DateTime
     */
    public function getCiCreated()
    {
        return $this->ciCreated;
    }

    /**
     * Set cit
     *
     * @param \AppBundle\Entity\City $cit
     *
     * @return ContactInfo
     */
    public function setCit(\AppBundle\Entity\City $cit = null)
    {
        $this->cit = $cit;

        return $this;
    }

    /**
     * Get cit
     *
     * @return \AppBundle\Entity\City
     */
    public function getCit()
    {
        return $this->cit;
    }

    /**
     * Set usr
     *
     * @param \AppBundle\Entity\User $usr
     *
     * @return ContactInfo
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
    /**
     * @var string
     */
    private $ciCompany;


    /**
     * Set ciCompany
     *
     * @param string $ciCompany
     *
     * @return ContactInfo
     */
    public function setCiCompany($ciCompany)
    {
        $this->ciCompany = $ciCompany;

        return $this;
    }

    /**
     * Get ciCompany
     *
     * @return string
     */
    public function getCiCompany()
    {
        return $this->ciCompany;
    }
}
