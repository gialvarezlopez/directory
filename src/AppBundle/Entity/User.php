<?php

namespace AppBundle\Entity;
use \Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 */
class User implements UserInterface
{
    /**
     * @var integer
     */
    private $usrId;

    /**
     * @var string
     */
    private $usrUsername;

    /**
     * @var string
     */
    private $usrPassword;

    /**
     * @var string
     */
    private $usrEmail;

    /**
     * @var string
     */
    private $usrRole;

    /**
     * @var boolean
     */
    private $usrStatus = false;

    /**
     * @var string
     */
    private $usrTokenConfirmation;

    /**
     * @var \DateTime
     */
    private $usrCreated = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     */
    private $usrUpdated = 'CURRENT_TIMESTAMP';

    /**
     * @var boolean
     */
    private $usrActive = true;

    /**
     * @var \AppBundle\Entity\Country
     */
    private $cou;

    /**
     * @var \AppBundle\Entity\ServiceType
     */
    private $st;


    /**
     * Get usrId
     *
     * @return integer
     */
    public function getUsrId()
    {
        return $this->usrId;
    }

    /**
     * Set usrUsername
     *
     * @param string $usrUsername
     *
     * @return User
     */
    public function setUsrUsername($usrUsername)
    {
        $this->usrUsername = $usrUsername;

        return $this;
    }

    /**
     * Get usrUsername
     *
     * @return string
     */
    public function getUsrUsername()
    {
        return $this->usrUsername;
    }

    /**
     * Set usrPassword
     *
     * @param string $usrPassword
     *
     * @return User
     */
    public function setUsrPassword($usrPassword)
    {
        $this->usrPassword = $usrPassword;

        return $this;
    }

    /**
     * Get usrPassword
     *
     * @return string
     */
    public function getUsrPassword()
    {
        return $this->usrPassword;
    }

    /**
     * Set usrEmail
     *
     * @param string $usrEmail
     *
     * @return User
     */
    public function setUsrEmail($usrEmail)
    {
        $this->usrEmail = $usrEmail;

        return $this;
    }

    /**
     * Get usrEmail
     *
     * @return string
     */
    public function getUsrEmail()
    {
        return $this->usrEmail;
    }

    /**
     * Set usrRole
     *
     * @param string $usrRole
     *
     * @return User
     */
    public function setUsrRole($usrRole)
    {
        $this->usrRole = $usrRole;

        return $this;
    }

    /**
     * Get usrRole
     *
     * @return string
     */
    public function getUsrRole()
    {
        return $this->usrRole;
    }

    /**
     * Set usrStatus
     *
     * @param boolean $usrStatus
     *
     * @return User
     */
    public function setUsrStatus($usrStatus)
    {
        $this->usrStatus = $usrStatus;

        return $this;
    }

    /**
     * Get usrStatus
     *
     * @return boolean
     */
    public function getUsrStatus()
    {
        return $this->usrStatus;
    }

    /**
     * Set usrTokenConfirmation
     *
     * @param string $usrTokenConfirmation
     *
     * @return User
     */
    public function setUsrTokenConfirmation($usrTokenConfirmation)
    {
        $this->usrTokenConfirmation = $usrTokenConfirmation;

        return $this;
    }

    /**
     * Get usrTokenConfirmation
     *
     * @return string
     */
    public function getUsrTokenConfirmation()
    {
        return $this->usrTokenConfirmation;
    }

    /**
     * Set usrCreated
     *
     * @param \DateTime $usrCreated
     *
     * @return User
     */
    public function setUsrCreated($usrCreated)
    {
        $this->usrCreated = $usrCreated;

        return $this;
    }

    /**
     * Get usrCreated
     *
     * @return \DateTime
     */
    public function getUsrCreated()
    {
        return $this->usrCreated;
    }

    /**
     * Set usrUpdated
     *
     * @param \DateTime $usrUpdated
     *
     * @return User
     */
    public function setUsrUpdated($usrUpdated)
    {
        $this->usrUpdated = $usrUpdated;

        return $this;
    }

    /**
     * Get usrUpdated
     *
     * @return \DateTime
     */
    public function getUsrUpdated()
    {
        return $this->usrUpdated;
    }

    /**
     * Set usrActive
     *
     * @param boolean $usrActive
     *
     * @return User
     */
    public function setUsrActive($usrActive)
    {
        $this->usrActive = $usrActive;

        return $this;
    }

    /**
     * Get usrActive
     *
     * @return boolean
     */
    public function getUsrActive()
    {
        return $this->usrActive;
    }

    /**
     * Set cou
     *
     * @param \AppBundle\Entity\Country $cou
     *
     * @return User
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

    /**
     * Set st
     *
     * @param \AppBundle\Entity\ServiceType $st
     *
     * @return User
     */
    public function setSt(\AppBundle\Entity\ServiceType $st = null)
    {
        $this->st = $st;

        return $this;
    }

    /**
     * Get st
     *
     * @return \AppBundle\Entity\ServiceType
     */
    public function getSt()
    {
        return $this->st;
    }
    
    //AUTH
    public function getPassword() {
        return $this->usrPassword;
    }
    public function getUsername(){
        return $this->usrEmail;
    }

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        return array($this->usrRole);
    }

    public function eraseCredentials()
    {

    }

    public function __toString() {
        if(is_null($this->usrRole)) {
            return 'Ajua';
        }
        return $this->usrRole;
    } 
    
    
    public function __construct()
    {
        $this->usrCreated = new \DateTime();
    }

    //END AUTH
    /**
     * @var boolean
     */
    private $usrNotificationContactForm = '1';

    /**
     * @var boolean
     */
    private $usrNotificationPayment = '1';


    /**
     * Set usrNotificationContactForm
     *
     * @param boolean $usrNotificationContactForm
     *
     * @return User
     */
    public function setUsrNotificationContactForm($usrNotificationContactForm)
    {
        $this->usrNotificationContactForm = $usrNotificationContactForm;

        return $this;
    }

    /**
     * Get usrNotificationContactForm
     *
     * @return boolean
     */
    public function getUsrNotificationContactForm()
    {
        return $this->usrNotificationContactForm;
    }

    /**
     * Set usrNotificationPayment
     *
     * @param boolean $usrNotificationPayment
     *
     * @return User
     */
    public function setUsrNotificationPayment($usrNotificationPayment)
    {
        $this->usrNotificationPayment = $usrNotificationPayment;

        return $this;
    }

    /**
     * Get usrNotificationPayment
     *
     * @return boolean
     */
    public function getUsrNotificationPayment()
    {
        return $this->usrNotificationPayment;
    }
    /**
     * @var boolean
     */
    private $usrForgotPassword = '0';


    /**
     * Set usrForgotPassword
     *
     * @param boolean $usrForgotPassword
     *
     * @return User
     */
    public function setUsrForgotPassword($usrForgotPassword)
    {
        $this->usrForgotPassword = $usrForgotPassword;

        return $this;
    }

    /**
     * Get usrForgotPassword
     *
     * @return boolean
     */
    public function getUsrForgotPassword()
    {
        return $this->usrForgotPassword;
    }
}
